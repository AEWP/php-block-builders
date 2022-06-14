<?php
/**
 * Class Cheetah
 *
 * @package PhpBlockBuilders\Blocks
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Blocks;

/**
 * Class Cheetah
 *
 * @package PhpBlockBuilders\Blocks
 */
class Cheetah extends CoreEmbed {

	/**
	 * The container block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'bauer-blocks/cheetah';

	/**
	 * Return a string representation of the Cheetah block..
	 *
	 * @param  string $content String text/html/url content.
	 * @param  array  $attrs All required block attributes.
	 *
	 * @return string The Gutenberg-compatible output.
	 */
	public static function create( string $content = '', array $attrs = [] ): string {

		$attrs = self::get_attributes( $attrs );
		$url           = esc_url( $content );
		$embed_id      = ltrim( wp_parse_url( $url, PHP_URL_PATH ), 'embed/' );
		$inner_content = "<div class=\"wp-block-bauer-blocks-cheetah bauer-block-embed\">{$url}</div>";

		$data = [
			'blockName'    => $attrs['block_name'],
			'innerContent' => [ $inner_content ],
			'attrs'        => [
				'url'              => $url,
				'embedId'          => $embed_id,
				'providerNameSlug' => $attrs['provider'],
			],
		];

		return serialize_block( $data );
	}

}
