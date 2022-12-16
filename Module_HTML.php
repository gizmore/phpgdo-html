<?php
namespace GDO\HTML;

use GDO\Core\GDO_Module;
use GDO\Util\Strings;

/**
 * Message provider for user contributed html input.
 * Filters html via htmlpurifier.
 * 
 * @author gizmore
 * @version 7.0.2
 * @since 7.0.1
 */
final class Module_HTML extends GDO_Module
{
	
	public int $priority = 40;
	
	public function thirdPartyFolders() : array
	{
		return ['htmlpurifier/'];
	}
	
	public function getLicenseFilenames() : array
	{
		return [
			'htmlpurifier/LICENSE',
		];
	}
	
	public static function DECODE(?string $s): ?string
	{
		return self::getPurifier()->purify(Strings::nl2brHTMLSafe($s));
	}
	
}
