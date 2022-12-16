<?php
namespace GDO\HTML;

/**
 * Filter an user contributed HTML message.
 * Pass a string through the purifier.
 * 
 * @author gizmore
 * @version 7.0.2
 * @since 7.0.2
 */
final class Decoder
{
	
	private static ?\HTMLPurifier $PURIFIER = null;
	
	public static function init(): void
	{
		self::$PURIFIER = self::_getPurifier();
	}
	
	/**
	 * Get the one and only default purifier.
	 */
	public static function getPurifier(): \HTMLPurifier
	{
		return self::$PURIFIER;
	}
	
	/**
	 * Filter an user contributed HTML message. 
	 */
	public static function purify(string $s): string
	{
		return self::getPurifier()->purify($s);
	}
	
	###############
	### Private ###
	###############
	private static function _getPurifier(): \HTMLPurifier
	{
		require GDO_PATH . 'GDO/HTML/htmlpurifier/library/HTMLPurifier.auto.php';
		$config = \HTMLPurifier_Config::createDefault();
		$config->set('URI.Host', GDO_DOMAIN);
		$config->set('HTML.Nofollow', true);
		$config->set('HTML.Doctype', 'HTML 4.01 Transitional');
		$config->set('URI.DisableExternalResources', false);
		$config->set('URI.DisableResources', false);
		$config->set('HTML.TargetBlank', true);
		$config->set('HTML.Allowed', 'br,a[href|rel|target],p,pre[class],code[class],img[src|alt],figure[style|class],figcaption,center,b,i,div[class],h1,h2,h3,h4,h5,h6,strong');
		$config->set('Attr.DefaultInvalidImageAlt', t('img_not_found'));
		$config->set('HTML.SafeObject', true);
		$config->set('Attr.AllowedRel', array('nofollow'));
		$config->set('HTML.DefinitionID', 'gdo6-message');
		$config->set('HTML.DefinitionRev', 1);
		if ($def = $config->maybeGetRawHTMLDefinition())
		{
			$def->addElement('figcaption', 'Block', 'Flow', 'Common');
			$def->addElement('figure', 'Block', 'Optional: (figcaption, Flow) | (Flow, figcaption) | Flow', 'Common');
		}
		return new \HTMLPurifier($config);
	}
	
}

Decoder::init();
