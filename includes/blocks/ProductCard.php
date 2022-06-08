<?php

namespace PhpBlockBuilders\Blocks;

use UK_CONTENT_M_AND_B_MIGRATION_PLUGIN\Modules\Set\Base;
use UK_CONTENT_M_AND_B_MIGRATION_PLUGIN\Modules\Concerns\StringManipulation;
use WP_Post;

/**
 * Class ProductCard
 *
 * package Block PhpBlockBuilders
 */
class ProductCard {

	use StringManipulation;

	const CONTAINER_BLOCK_NAME = 'bauer-blocks/bauer-product-card';
	const ITEM_BLOCK_NAME      = self::CONTAINER_BLOCK_NAME . '-item';

	/**
	 * Create a Product card Block from a legacy id input
	 *
	 * @param  int $legacy_id
	 *
	 * @return string
	 */
	public static function create_from_legacy_id( int $legacy_id ) : string {

		$rtn     = '';
		$post_id = absint( Base::get_post_id_by_meta_key( 'legacy_id', $legacy_id, 'product_card' ) );
		if ( 0 < $post_id ) {

			$post  = get_post( $post_id );
			$meta  = get_post_meta( $post_id ) ?: [];
			$items = [];

			if ( ! empty( $meta['product_card_meta'] ) ) {
				$meta['product_card_meta'] = array_map( 'maybe_unserialize', $meta['product_card_meta'] );
			}

			if ( $post instanceof WP_Post ) {
				$product_card_block = self::create_container_block( $post, $meta );

				if ( ! empty( $product_card_block ) ) {

					$items = self::create_all_items( $meta['product_card_meta'] ?: [] );

					$rtn  = str_replace( '/-->', '-->', $product_card_block );
					$rtn .= implode( '', $items );
					$rtn .= '<!-- /wp:bauer-blocks/bauer-product-card -->';
				}
			}
		}


		return $rtn;

	}


	/**
	 * Create the Product Card container block
	 *
	 * @param  \WP_Post $post
	 * @param  array    $meta
	 *
	 * @return string
	 */
	public static function create_container_block( WP_Post $post, array $meta ): string {

		$rtn                 = '';
		$product_header_meta = $meta['product_card_meta'] ? $meta['product_card_meta'][0]['product_header'] : [];

		$title       = self::json_encode_clean_string( $post->post_title );
		$description = self::json_encode_clean_string( $product_header_meta['description'] ?: '' );

		$attributes = [
			'productId'    => $post->ID,
			'productTitle' => $title,
			'actionText'   => esc_attr( $product_header_meta['action_text'] ) ?: esc_attr( 'View Offer' ),
			'actionLink'   => esc_url( $product_header_meta['action_link'] ) ?: '',
			'description'  => $description,
			'amazonAward'  => self::json_encode_clean_string( $product_header_meta['amazon_award'] ?: '' ),
			'price'        => self::json_encode_clean_string( self::get_number_from_string ( $product_header_meta['price'] ) ) ?: '',
			'AmazonId'     => esc_attr( $product_header_meta['amazon_id'] ) ?: '',
		];

		if ( ! empty( $attributes['productId'] ) ) {

			$block = [
				'blockName'    => self::CONTAINER_BLOCK_NAME,
				'innerContent' => [],
				'attrs'        => $attributes,
			];

			$rtn = serialize_block( $block );

		}

		return $rtn;

	}

	/**
	 * Image groups are nested parts of the post_meta we need to find these and then generate the block
	 *
	 * @param  array $meta
	 *
	 * @return array
	 */
	private static function create_all_items( array $meta ): array {
		$rtn = [];
		if ( ! empty( $meta ) ) {
			foreach ( $meta as $mt ) {
				if ( ! empty( $mt['image_group'] ) ) {
					foreach ( $mt['image_group'] as $ig ) {
						$rtn[] = self::create_item_block( $ig );
					}
				}
			}
		}

		return $rtn;
	}


	/**
	 * Create each product card item block
	 *
	 * @param  array $data
	 *
	 * @return string
	 */
	private static function create_item_block( array $data ) : string {

		$attributes = [
			'imageID'      => absint( $data['image'] ),
			'imageIsCover' => '',
			'imageAlt'     => wp_filter_kses( $data['alt_text'] ),
			'imageTitle'   => wp_filter_kses( $data['title_text'] ),
			'imageCaption' => '',
			'imageCredits' => '',
			'imageURL'     => wp_get_attachment_image_url( $data['image'], 'full' ),
		];

		$block = [
			'blockName'    => self::ITEM_BLOCK_NAME,
			'innerContent' => [],
			'attrs'        => $attributes,
		];

		return serialize_block( $block );

	}


}
