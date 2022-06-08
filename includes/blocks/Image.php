<?php

namespace PhpBlockBuilders\Blocks;

use UK_CONTENT_PUBLISH_MIGRATION_PLUGIN\Modules\Set\Base;


/**
 * Class Image
 *
 * @package PhpBlockBuilders\Blocks
 */
class Image extends Base implements BlockInterface {

	/**
	 * Creates an Image block
	 *
	 * @param  array $attrs
	 *
	 * @return string
	 */
	public static function create( array $attrs ): string {

		if ( empty( $attrs['content'] ) ) {
			return '';
		}

		$image_id = $this->set_media()->create( $attrs['content'] );

		if ( 0 === $image_id ) {
			return '';
		}

		$handles          = $attrs['handles'] ?? [];
		$imgix_url_params = ! empty( $handles ) ? $this->create_imgix_url_params( current( $handles ) ) : '';
		$image_url        = wp_get_attachment_image_url( $image_id, 'full' ) . $imgix_url_params;

		$inner_content  = '<figure class="wp-block-image size-large">';
		$inner_content .= '<img src="' . $image_url . '" ';
		$inner_content .= 'alt="' . esc_attr( $attrs['content']['altText'] ?? '' ) . '" ';
		$inner_content .= 'class="wp-image-' . absint( $image_id ) . '" />';
		$inner_content .= ! empty( $attrs['content']['caption'] ) ? ( '<figcaption>' . $attrs['content']['caption'] . '</figcaption>' ) : '';
		$inner_content .= '</figure>';

		$data = [
			'blockName'    => 'core/image',
			'innerContent' => [ $inner_content ],
			'attrs'        => [
				'id'              => $image_id,
				'sizeSlug'        => 'large',
				'linkDestination' => 'none',
				'handles'         => $handles,
			],
		];

		return serialize_block( $data );
	}

	/**
	 * Build an imgix url query based on supplied data array
	 *
	 * @param  array  $data
	 *
	 * @return string
	 */
	private function create_imgix_url_params( array $data ) : string {

		if ( empty( $data ) ) {
			return '';
		}

		// map input variables to imgix params
		$rtn = [
			'w'    => $data['height'],
			'h'    => $data['height'],
			'rect' => $data['x'] . ',' . $data['y'] . ',' . $data['x2'] . ',' . $data['y2'],
		];


		return '?' . http_build_query( $rtn );

	}


}
