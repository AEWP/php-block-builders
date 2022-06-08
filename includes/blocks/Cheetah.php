<?php
/**
 * Class Cheetah
 *
 * @package PhpBlockBuilders\Blocks
 */

namespace PhpBlockBuilders\Blocks;

/**
 * Class Cheetah
 *
 * @package PhpBlockBuilders\Blocks
 */
class Cheetah extends Embed {


	public static string $block_name = 'bauer-blocks/cheetah';

	/**
	 * Creates an Instagram block
	 *
	 * @param  string $content
	 * @param  array  $attrs
	 *
	 * @return string
	 */
	public static function create( string $content = '', array $attrs = [] ): string {
		$url           = esc_url( $content );
		$provider      = $attrs['provider'];
		$embed_id      = ltrim( wp_parse_url( $url, PHP_URL_PATH ), 'embed/' );
		$inner_content = "<div class=\"wp-block-bauer-blocks-cheetah bauer-block-embed\">{$url}</div>";

		$data = [
			'blockName'    => self::$block_name,
			'innerContent' => [ $inner_content ],
			'attrs'        => [
				'url'              => $url,
				'embedId'          => $embed_id,
				'providerNameSlug' => $provider,
			],
		];

		return serialize_block( $data );
	}

}
