<?php
/**
 * Class Twitter
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

/**
 * Class Twitter
 *
 * @package PhpBlockBuilders\Block
 */
class EmbedTwitter extends CoreEmbed {

	/**
	 * Create a twitter block
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
