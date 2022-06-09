<?php
/**
 * Class TikTok
 *
 * @package PhpBlockBuilders\Blocks
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Blocks;

/**
 * Class TikTok
 *
 * @package PhpBlockBuilders\Blocks
 */
class TikTok extends CoreEmbed {

	/**
	 * Creates a TikTok block
	 *
	 * @param  string $content Embed url.
	 * @param  array  $attrs Attributes array.
	 *
	 * @return string
	 */
	public static function create( string $content = '', array $attrs = [] ): string {
		$class_names = [
			'is-type-video',
			'is-type-rich',
		];
		return self::create_gutenberg_block( $content, $attrs['provider'], $class_names ) ?? '';

	}




}
