<?php

namespace PhpBlockBuilders\Blocks;

use UK_CONTENT_M_AND_B_MIGRATION_PLUGIN\Modules\Set\Base;
use UK_CONTENT_M_AND_B_MIGRATION_PLUGIN\Modules\Concerns\StringManipulation;
use WP_Post;

/**
 * Class Gallery
 *
 * package Block PhpBlockBuilders
 */
class Gallery {

	use StringManipulation;

	const CONTAINER_BLOCK_NAME = 'bauer-blocks/bauer-gallery';
	const ITEM_BLOCK_NAME      = self::CONTAINER_BLOCK_NAME . '-item';

	/**
	 * Create a Gallery Block from the input params provided bny
	 * https://developer.wordpress.org/reference/hooks/post_gallery/
	 *
	 * @param  string $output
	 * @param  null   $attributes
	 * @param  null   $instance
	 *
	 * @return string
	 */
	public static function create_from_shortcode( $output = '', $attributes = null, $instance = null ) {
		$post                = self::get_complete_post( absint( $attributes['id'] ), $attributes['template'] ?? '' );
		$gallery_block       = self::create_container_block( $post );
		$gallery_items       = [];
		$complete_block_html = '';

		// we have to build the block content
		if ( ! empty( $post['gallery_items'][0]['image_group'] ) ) {
			foreach ( $post['gallery_items'][0]['image_group'] as $item ) {
				if ( ! empty( $item ) ) {
					$gallery_items[] = self::create_item_block( $item, $post['post_title'] );
				}
			}
		}

		// and then hack it in,
		// @todo find a WP method for inserting block content into a block, innerBlocks and innerContent from serialize_block is for the attributes
		if ( ! empty( $gallery_items ) ) {
			$complete_block_html  = str_replace( '/-->', '-->', $gallery_block );
			$complete_block_html .= implode( '', $gallery_items );
			$complete_block_html .= '<!-- /wp:bauer-blocks/bauer-gallery -->';
		}


		return $complete_block_html;
	}

	/**
	 * Creates the Gallery Block container html
	 *
	 * @param  array $data
	 *
	 * @return string
	 */
	private static function create_container_block( array $data ): string {

		$rtn = '';

		if ( ! empty( $data ) ) {

			$attributes = [
				'galleryId'       => absint( $data['ID'] ),
				'galleryTitle'    => self::json_encode_clean_string( $data['post_title'] ),
				'galleryTemplate' => esc_attr( $data['gallery_template'] ),
			];

			$block = [
				'blockName'    => self::CONTAINER_BLOCK_NAME,
				'innerContent' => [ $data['post_content'] ],
				'attrs'        => $attributes,
			];

			$rtn = serialize_block( $block );
		}

		return $rtn;

	}

	/**
	 * Returns each Gallery Item HTML
	 *
	 * @param  array  $data
	 * @param  string $gallery_title
	 *
	 * @return string
	 */
	private static function create_item_block( array $data, string $gallery_title ): string {

		$attributes = [
			'galleryTitle'     => esc_html( $gallery_title ),
			'imageID'          => $data['image'],
			'imageIsCover'     => null,
			'imageURL'         => wp_get_attachment_image_url( $data['image'], 'full' ),
			'imageTitle'       => self::json_encode_clean_string( $data['title_text'] ),
			'imageDesc'        => self::json_encode_clean_string( $data['description'] ),
			'imageAlt'         => self::json_encode_clean_string( $data['alt_text'] ),
			'imageCaption'     => self::json_encode_clean_string( $data['caption'] ),
			'imageCredits'     => self::json_encode_clean_string( $data['credits'] ),
			'imageActionText'  => esc_html( $data['action_text'] ),
			'imageActionLink'  => esc_url_raw( $data['action_link'] ),
			'imageAmazonId'    => esc_html( $data['amazon_id'] ),
			'imageAmazonAward' => esc_html( $data['amazon_award'] ),
			'imagePrice'       => self::get_number_from_string( $data['price'] ) ?: '',
		];

		$block = [
			'blockName'    => self::ITEM_BLOCK_NAME,
			'innerContent' => [],
			'attrs'        => $attributes,
		];

		return serialize_block( $block );

	}

	/**
	 * Get all the data required to build a complete gallery from one array
	 *
	 * @param  int    $legacy_id
	 * @param  string $template
	 *
	 * @return array|WP_Post
	 */
	private static function get_complete_post( int $legacy_id, string $template ) {
		$rtn     = [];
		$post_id = absint( Base::get_post_id_by_meta_key( 'legacy_id', $legacy_id, 'gallery' ) );

		if ( 0 === $post_id ) {
			// @todo this creates galleries on the fly and is slow, ideally galleries should be created prior to any content creation
			$post_id = self::create_post_by_legacy_id( $legacy_id, $template );
		}

		$post = get_post( $post_id, ARRAY_A );
		if ( ! empty( $post ) ) {
			$rtn                     = $post;
			$rtn['gallery_template'] = $template;
			$rtn['gallery_items']    = get_post_meta( $post_id, 'gallery_meta' );
		}

		return $rtn;
	}

	/**
	 * Create a Gallery Post from a legacy id
	 *
	 * @param  int    $legacy_id
	 * @param  string $template
	 *
	 * @return int
	 * @todo this breaks pattern in a lot of ways, so needs refactoring out of here and into something better
	 */
	private static function create_post_by_legacy_id( int $legacy_id, string $template ): int {
		$get_gallery               = new \UK_CONTENT_M_AND_B_MIGRATION_PLUGIN\Modules\Get\Cpt\Gallery();
		$set_gallery               = new \UK_CONTENT_M_AND_B_MIGRATION_PLUGIN\Modules\Set\Cpt\Gallery();
		$post_id                   = 0;
		$data                      = $get_gallery->get_single_by_id( $legacy_id );
		$data['media']['template'] = $template;

		if ( ! empty( $data ) ) {
			$post_id = $set_gallery->create_post( $data );
		}

		return absint( $post_id );

	}


}
