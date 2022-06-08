<?php
/**
 * Class TikTok
 *
 * @package PhpBlockBuilders\Blocks
 */

namespace PhpBlockBuilders\Blocks;

/**
 * Class TikTok
 *
 * @package PhpBlockBuilders\Blocks
 */
class TikTok extends Embed {



	/**
	 * Creates a TikTok block
	 * @param  array  $attrs
	 *
	 * @return string
	 */
	public static function create( array $attrs ): string {

		$url      = $attrs['content']['url'];
		$provider = $attrs['content']['provider'];

		$class_names   = [
			'wp-block-embed',
			'is-type-video',
			'is-type-rich'
		];
		$inner_content = self::create_inner_content( $url, $provider, $class_names );

		return self::create_gutenberg_block( $url, $provider, $inner_content ) ?? '';

	}




}
