<?php
/**
 * Class Twitter
 *
 * @package PhpBlockBuilders\Blocks
 */

namespace PhpBlockBuilders\Blocks;

/**
 * Class Twitter
 *
 * @package PhpBlockBuilders\Blocks
 */
class Twitter extends Embed {

	/**
	 * Create a twitter block
	 *
	 * @param  array  $attrs
	 *
	 * @return string
	 */
	public static function create( array $attrs ): string {
		$url      = esc_url( $attrs['content']['url'] );
		$provider = $attrs['content']['provider'];

		$class_names   = [
			'wp-block-embed',
			'is-type-rich',
		];
		$inner_content = self::create_inner_content( $url, $provider, $class_names );

		return self::create_gutenberg_block( $url, $provider, $inner_content ) ?? '';
	}


}
