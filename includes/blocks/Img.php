<?php

namespace PhpBlockBuilders\Blocks;

use DOMElement;
use UK_CONTENT_M_AND_B_MIGRATION_PLUGIN\Modules\Set\Cpt\Media;
use UK_CONTENT_M_AND_B_MIGRATION_PLUGIN\Modules\Set\Report\Article as ReportArticle;

/**
 * Class Img
 *
 * package Block PhpBlockBuilders
 */
class Img {

	/**
	 * Update all image src attributes in the original html string with updated file locations based on the
	 * MEDIA_STORAGE_URI constant and creates a gutenberg image block
	 *
	 * @param  DOMElement                                                 $node
	 * @param  \UK_CONTENT_M_AND_B_MIGRATION_PLUGIN\Modules\Set\Cpt\Media $set_media
	 * @param  string                                                     $new_element_name
	 * @param  bool                                                       $create_block
	 * @param  null|ReportArticle                                         $report_article
	 *
	 * @return void
	 *
	 * @todo catch and handle errors
	 */
	public static function create_block( DOMElement $node, Media $set_media, string $new_element_name, bool $create_block = true, $report_article = null ): void {

		$original_img_url = pathinfo( $node->getAttribute( 'src' ) );
		if ( ! empty( $original_img_url['basename'] ) ) {
			$id     = $set_media->set_report_article( $report_article )->create_post( esc_url_raw( $node->getAttribute( 'src' ) ) );
			$wp_url = wp_get_attachment_image_url( absint( $id ), 'full' );
			if ( ! empty( $wp_url ) ) {
				$node->setAttribute( 'src', $wp_url );
				if ( true === $create_block ) {
					if ( 'p' !== $node->parentNode->nodeName ) {
						if ( $report_article instanceof ReportArticle ) {
							$report_article->set_value( 'inline_images', sanitize_title( pathinfo( $node->getAttribute( 'src' ),  PATHINFO_BASENAME ), 'name', 'attachment'), true );
						}
					} else {
						self::create_gutenberg_block( $node, $id, $new_element_name, false, $report_article, $report_article );

					}
				}
			}
		}

	}



	/**
	 * Create each mage block
	 *
	 * @param  \DOMElement $node
	 * @param  int         $post_id
	 * @param  string      $new_element_name
	 * @param  bool        $parent_parent
	 */
	public static function create_gutenberg_block( DOMElement $node, int $post_id, string $new_element_name, bool $parent_parent = false, $report_article = null ):void {

		$inner_content = self::create_inner_content( $node, $post_id );

		$data = [
			'blockName'    => 'core/image',
			'innerContent' => [ $inner_content ],
			'attrs'        => [
				'id'              => $post_id,
				'sizeSlug'        => 'large',
				'linkDestination' => 'none',
			],
		];

		$element_content = serialize_block( $data );
		$new_element     = $node->ownerDocument->createElement( $new_element_name, $element_content );

		if ( null !== $node->parentNode && null !== $node->parentNode->parentNode ) {
			$node->parentNode->parentNode->insertBefore( $new_element, $node->parentNode );
			$node->parentNode->removeChild( $node );

			if ( $report_article instanceof ReportArticle ) {
				$report_article->set_value( 'image_blocks', $post_id, true );
			}
		}
	}

	/**
	 * Create image block inner content
	 *
	 * @param  \DOMElement $node
	 * @param  int         $post_id
	 *
	 * @return string
	 */
	public static function create_inner_content( DOMElement $node, int $post_id ): string {

		$class_name = $node->getAttribute( 'class' ) ? [ 'className' => $node->getAttribute( 'class' ) ] : [];
		$src        = $node->getAttribute( 'src' ) ?: '';
		$caption    = $node->getAttribute( 'alt' ) ? wp_get_attachment_caption( $post_id ) : wp_basename( $src );

		$rtn  = '<figure class="wp-block-image size-large ' . implode( ' ', $class_name ) . '">';
		$rtn .= '<img src="' . esc_url( $src ) . '" ';
		$rtn .= 'alt="' . wp_strip_all_tags( $caption ) . '" ';
		$rtn .= 'class="wp-image-' . absint( $post_id ) . '" />';
		$rtn .= '<figcaption>' . $caption . '</figcaption>';
		$rtn .= '</figure>';

		return wp_kses_post( $rtn );

	}





}
