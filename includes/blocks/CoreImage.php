<?php
/**
 * PHP Block Builders
 *
 * @package PhpBlockBuilders\Blocks
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Blocks;

use PhpBlockBuilders\BlockBase;

/**
 * Core Image Gutenberg block.
 *
 * @package PhpBlockBuilders\Blocks
 */
class CoreImage extends BlockBase {

	/**
	 * The container block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'core/image';


	/**
	 * Convert Salesforce paragraphs to Gutenberg equivalent.
	 *
	 * @param  string $content Image id.
	 * @param  array  $attrs All required block attributes.
	 *
	 * @return string The converted Gutenberg-compatible output.
	 */
	public static function create( string $content = '', array $attrs = [] ): string {
		$image_id       = absint( $content );
		$attachment_url = \wp_get_attachment_image_url( $image_id, 'full' );
		$classname      = $attrs['classname'] ?? '';
		$rtn            = '';

		if ( empty( $attachment_url ) ) {
			return $rtn;
		}

		$alt       = \get_post_meta( $image_id, '_wp_attachment_image_alt', true ) ?? '';
		$classname = ! empty( $classname ) ? $classname : 'wp-block-image size-large';

		$image         = sprintf( '<img src="%1s" alt="%2s" class="wp-image-%3s" />', $attachment_url, esc_attr( $alt ), absint( $image_id ) );
		$inner_content = Figure::create_html( $image, [ 'classname' => $classname ] );

		// $block_template = <<<'TEMPLATE'
		// <figure class="%1s">
		// <img src="%2s" alt="%3s" class="wp-image-%4b" />
		// </figure>
		// TEMPLATE;
		//
		// $inner_content = sprintf(
		// $block_template,
		// esc_attr( $classname ), // 1
		// $attachment_url, // 2
		// esc_attr( $alt ), // 3
		// absint( $image_id )// 4
		// );

		$data = [
			'blockName'    => self::$block_name,
			'innerContent' => [ $inner_content ],
			'attrs'        => [
				'mediaId'   => $image_id,
				'mediaLink' => $attachment_url,
				'mediaType' => 'image',
			],
		];

		return serialize_block( $data );
	}


}
