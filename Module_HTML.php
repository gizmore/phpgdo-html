<?php
namespace GDO\HTML;

use GDO\Core\GDO_Module;
use GDO\UI\GDT_Message;
use GDO\Util\Strings;

/**
 * Message provider for user contributed html input.
 * Filters html via htmlpurifier.
 * Base decoder for rich content editors.
 *
 * @version 7.0.2
 * @since 7.0.1
 * @author gizmore
 */
final class Module_HTML extends GDO_Module
{

	public int $priority = 30;
	public string $license = 'LGPL2.1';

	public function thirdPartyFolders(): array
	{
		return ['htmlpurifier/'];
	}

	public function getLicenseFilenames(): array
	{
		return ['htmlpurifier/LICENSE'];
	}

	###############
	### Decoder ###
	###############
	public function onModuleInit(): void
	{
		GDT_Message::addDecoder('HTML', [self::class, 'DECODE']);
	}

	public function decode(string $s): string
	{
		$s = Strings::nl2brHTMLSafe($s);
		return $this->purify($s);
	}

	public function purify(string $s): string
	{
		return Decoder::purify($s);
	}

}
