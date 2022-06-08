<?php
/**
 * Class YouTube
 *
 * @package PhpBlockBuilders\Blocks
 */

namespace PhpBlockBuilders\Blocks;

/**
 * Class YouTube
 *
 * @package PhpBlockBuilders\Blocks
 */
class YouTube extends Embed {

	/**
	 * Create a twitter block
	 *
	 * @param  array  $attrs
	 *
	 * @return string
	 */
	public static function create(  array $attrs ): string {
		$url      = esc_url( $attrs['content']['url'] );
		$provider = $attrs['content']['provider'];

		$class_names   = [ 'is-type-video', 'wp-embed-aspect-16-9', 'wp-has-aspect-ratio', 'wp-block-embed' ];
		$inner_content = self::create_inner_content( $url, $provider, $class_names );

		return self::create_gutenberg_block( $url, $provider, $inner_content ) ?? '';
	}

}
