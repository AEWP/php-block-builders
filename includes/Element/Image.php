<?php
/**
 * Class Image
 *
 * @package PhpBlockBuilders\Element
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Element;

use function esc_attr;
use function esc_url;
use function get_post_meta;
use function wp_get_attachment_image_url;

/**
 * Class Image
 *
 * @package PhpBlockBuilders\Element
 */
class Image {

	/**
	 * Creates the media text image html and relevant attributes
	 *
	 * @param  int   $image_id  Attachment post id.
	 * @param  array $attrs  Attributes.
	 *
	 * @return array
	 */
	public static function create( int $image_id, array $attrs = [] ): array {
		$rtn = [
			'image_html' => '<img src="" alt="" />',
			'attrs'      => [
				'mediaId'   => '',
				'mediaLink' => '',
				'mediaType' => 'image',
			],
		];

		if ( $image_id > 0 ) {

			$classname      = $attrs['classname'] ?? 'wp-image-' . $image_id . ' size-full';
			$alt            = $attrs['alt'] ?? get_post_meta( $image_id, '_wp_attachment_image_alt', true );
			$attachment_url = wp_get_attachment_image_url( $image_id, 'full' );
			$image_attrs    = '';

			if ( isset( $attrs['image_attrs'] ) ) {
				foreach ( $attrs['image_attrs'] as $k => $v ) {
					$image_attrs .= ' ' . $k . '="' . $v . '"';
				}
			}

			$image_template =
				<<<'TEMPLATE'
				<img src="%1$s" alt="%2$s" class="%3$s" %4$s/>
				TEMPLATE;

			$rtn['image_html'] = sprintf(
				$image_template,
				esc_url( $attachment_url ), // 1
				esc_attr( $alt ), // 2
				esc_attr( $classname ), // 3
				esc_attr( $image_attrs ) // 4
			);

			$rtn['attrs']['mediaId']   = $image_id;
			$rtn['attrs']['mediaLink'] = $attachment_url;

		}

		return $rtn;

	}

}
