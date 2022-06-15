<?php
/**
 * Class Image
 *
 * @package PhpBlockBuilders\Elements
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Elements;

use PhpBlockBuilders\BlockInterface;

/**
 * Class Image
 *
 * @package PhpBlockBuilders\Elements
 */
class Image {

	/**
	 * Creates the media text image html and relevant attributes
	 *
	 * @param  int   $image_id  Attachment post id.
	 * @param  array $attrs Attributes.
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
			$alt            = $attrs['alt'] ?? \get_post_meta( $image_id, '_wp_attachment_image_alt', true );
			$attachment_url = \wp_get_attachment_image_url( $image_id, 'full' );

			$image_template =
				<<<'TEMPLATE'
			<img src="%1$s" alt="%2$s" class="%3$s"/>
			TEMPLATE;

			$rtn['image_html'] = sprintf(
				$image_template,
				\esc_url( $attachment_url ), // 1
				\esc_attr( $alt ), // 2
				\esc_attr( $classname ) // 3
			);

			$rtn['attrs']['mediaId']   = $image_id;
			$rtn['attrs']['mediaLink'] = $attachment_url;

		}

		return $rtn;

	}

}
