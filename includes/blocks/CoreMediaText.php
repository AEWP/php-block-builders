<?php
/**
 * Mecum Salesforce Connector
 *
 * @package PhpBlockBuilders\Blocks
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Blocks;

use MecumSalesforceConnector\Blocks\{CoreGroup, CoreParagraph};

/**
 * Core Media & Text Gutenberg block.
 */
class CoreMediaText {
	/**
	 * Parse Salesforce content and split it into separate paragraphs if too long.
	 *
	 * @param string $content   Salesforce content.
	 * @param array  $image_ids The WP attachment IDs.
	 *
	 * @return string The converted Gutenberg-compatible output.
	 */
	public static function convert_to_media_text_blocks( string $content, array $image_ids ): string {
		$html           = '';
		$countable_html = '';
		$section_count  = 0;

		$parts = array_filter( explode( '.', $content ) );

		foreach ( $parts as $key => $part ) {
			// Restore the full stop.
			$new_part = "{$part}.";

			$countable_html .= $new_part;

			$media_position = $section_count % 2 === 0 ? 'left' : 'right';

			if ( str_word_count( $countable_html ) > 70 || $key === array_key_last( $parts ) ) {
				$image_id       = $image_ids[ $section_count ] ?? 0;
				$html          .= self::convert_to_media_text_block( $countable_html, $image_id, $media_position );
				$html          .= CoreGroup::insert();
				$countable_html = '';
				$section_count++;
			}
		}

		return $html;
	}

	/**
	 * Convert Salesforce text to Gutenberg equivalent.
	 *
	 * @param string $content        The block content.
	 * @param int    $image_id       The WP attachment ID.
	 * @param string $media_position The media position (left or right).
	 *
	 * @return string The Gutenberg-compatible output.
	 */
	public static function convert_to_media_text_block( string $content, int $image_id, string $media_position ): string {

		$block_attrs = [
			'lock' => [
				'move'   => true,
				'remove' => true,
			],
		];

		if ( $media_position === 'right' ) {
			$block_attrs['mediaPosition'] = $media_position;
		}

		$image       = self::create_embedded_image( absint( $image_id ) );
		$image_html  = $image['image_html'];
		$block_attrs = array_merge( $block_attrs, $image['attrs'] );

		$block_template = <<<'TEMPLATE'
		<div class="wp-block-media-text alignwide %1s is-stacked-on-mobile">
		<figure class="wp-block-media-text__media">%2$s</figure>
		<div class="wp-block-media-text__content">
		%3$s
		</div>
		</div>
		TEMPLATE;

		$inner_content = sprintf(
			$block_template,
			$media_position === 'right' ? \esc_attr( "has-media-on-the-{$media_position}" ) : '', // 1
			$image_html, // 2
			\filter_block_kses_value( CoreParagraph::convert_to_paragraph_block( $content ), 'post' ) // 3
		);

		$data = [
			'blockName'    => 'core/media-text',
			'innerContent' => [ $inner_content ],
			'attrs'        => $block_attrs,
		];

		return serialize_block( $data );

	}

	/**
	 * Creates the media text image html and relevant attributes
	 *
	 * @param int $image_id Attachment post id.
	 *
	 * @return array
	 */
	private static function create_embedded_image( $image_id ) : array {

		$rtn = [
			'image_html' => '',
			'attrs'      => [
				'mediaId'   => '',
				'mediaLink' => '',
				'mediaType' => 'image',
			],
		];

		if ( $image_id > 0 ) {

			$image_template =
			<<<'TEMPLATE'
			<img src="%1$s" alt="%2$s" class="wp-image-%3$s size-full"/>
			TEMPLATE;

			$attachment_url = \wp_get_attachment_image_url( $image_id, 'full' );

			$rtn['image_html'] = sprintf(
				$image_template,
				\esc_url( $attachment_url ), // 1
				\esc_attr( \get_post_meta( $image_id, '_wp_attachment_image_alt', true ) ), // 2
				\esc_attr( $image_id ) // 3
			);

			$rtn['attrs']['mediaId']   = $image_id;
			$rtn['attrs']['mediaLink'] = $attachment_url;

		}

		return $rtn;

	}

}
