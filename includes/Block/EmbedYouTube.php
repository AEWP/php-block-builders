<?php
/**
 * Class YouTube
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

/**
 * Class YouTube
 *
 * @package PhpBlockBuilders\Block
 */
class EmbedYouTube extends CoreEmbed {

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
			'is-type-video',
			'wp-embed-aspect-16-9',
			'wp-has-aspect-ratio',
		];

		return self::create_gutenberg_block( $content, $attrs['provider'], $class_names ) ?? '';
	}

}