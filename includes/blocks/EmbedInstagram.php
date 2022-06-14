<?php
/**
 * Class Instagram
 *
 * @package PhpBlockBuilders\Blocks
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Blocks;

/**
 * Class Instagram
 *
 * @package PhpBlockBuilders\Blocks
 */
class EmbedInstagram extends CoreEmbed {

	/**
	 * Creates an Instagram block
	 *
	 * @param  string $content Embed url.
	 * @param  array  $attrs Attributes array.
	 *
	 * @return string
	 */
	public static function create( string $content = '', array $attrs = [] ): string {
		$class_names = [
			'is-type-rich',
		];
		return self::create_gutenberg_block( $content, $attrs['provider'], $class_names ) ?? '';

	}

}
