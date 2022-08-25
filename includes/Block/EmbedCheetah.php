<?php
/**
 * Class Cheetah
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

/**
 * Class Cheetah
 *
 * @package PhpBlockBuilders\Block
 */
class EmbedCheetah extends CoreEmbed {

	/**
	 * The container block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'embed/cheetah';

	/**
	 * Return a string representation of the Cheetah block..
	 *
	 * @param  string $content  String text/html/url content.
	 * @param  array  $attrs  All required block attributes.
	 * @param  bool   $render Should this block render (without comments) or serialize.
	 *
	 * @return string The Gutenberg-compatible output.
	 */
	public static function create( string $content = '', array $attrs = [], bool $render = false ): string {

		$data                              = self::get_data( $attrs );
		$embed_id                          = ltrim( wp_parse_url( $content, PHP_URL_PATH ), 'embed/' );
		$inner_content                     = sprintf( '<div class="wp-block-Block-cheetah block-embed">%s</div>', $content );
		$data['innerContent']              = [ $inner_content ];
		$data['attrs']['url']              = \esc_url( $content );
		$data['attrs']['embedId']          = \esc_attr( $embed_id );
		$data['attrs']['providerNameSlug'] = $attrs['provider'];

		return parent::return_block_html( $data, $render );
	}

}
