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
	 * @param  bool   $render Should this block render (without comments) or serialize.
	 *
	 * @return string
	 */
	public static function create( string $content = '', array $attrs = [], bool $render = false ): string {
		$class_names = [
			'is-type-video',
			'wp-embed-aspect-16-9',
			'wp-has-aspect-ratio',
		];

		return self::create_gutenberg_block( $content, $attrs['provider'], $class_names, $render ) ?? '';
	}

}
