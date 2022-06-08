<?php
/**
 * Mecum Salesforce Connector
 *
 * @package PhpBlockBuilders\Blocks
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Blocks;

/**
 * Core Image Gutenberg block.
 */
class CoreImage {


	/**
	 * Convert Salesforce paragraphs to Gutenberg equivalent.
	 *
	 * @param  int    $image_id  WP_Post ID.
	 * @param  string $classname  Optional figure classname string.
	 *
	 * @return string The converted Gutenberg-compatible output.
	 */
	public static function convert_to_image_block( int $image_id, string $classname = '' ): string {
		$attachment_url = \wp_get_attachment_image_url( $image_id, 'full' );
		$rtn            = '';

		if ( empty( $attachment_url ) ) {
			return $rtn;
		}

		$alt       = \get_post_meta( $image_id, '_wp_attachment_image_alt', true ) ?? '';
		$classname = ! empty( $classname ) ? $classname : 'wp-block-image size-large';

		$block_template = <<<'TEMPLATE'
			<figure class="%1s">
			<img src="%2s" alt="%3s" class="wp-image-%4b" />
			</figure>
			TEMPLATE;

		$inner_content = sprintf(
			$block_template,
			esc_attr( $classname ), // 1
			$attachment_url, // 2
			esc_attr( $alt ), // 3
			absint( $image_id )// 4
		);

		$attrs = [
			'blockName'    => 'core/image',
			'innerContent' => [ $inner_content ],
			'attrs'        => [
				'mediaId'   => $image_id,
				'mediaLink' => $attachment_url,
				'mediaType' => 'image',
			],
		];

		return serialize_block( $attrs );

	}


}
