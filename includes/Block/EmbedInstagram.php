<?php
/**
 * Class Instagram
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

/**
 * Class Instagram
 *
 * @package PhpBlockBuilders\Block
 */
class EmbedInstagram extends CoreEmbed {

	/**
	 * Creates an Instagram block
	 *
	 * @param  string $content  Embed url.
	 * @param  array  $attrs  Attributes array.
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
