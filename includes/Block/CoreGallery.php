<?php
/**
 * Class CoreGallery
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;
use PhpBlockBuilders\Element\Figure;

/**
 * Class CoreGallery
 *
 * @package PhpBlockBuilders\Block
 */
class CoreGallery extends BlockBase {

	/**
	 * The container block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'core/gallery';


	/**
	 * The block classname.
	 *
	 * @var string
	 */
	public static string $block_classname = 'wp-block-gallery has-nested-images columns-default is-cropped';

	/**
	 * The items block classname
	 *
	 * @var string
	 */
	public static string $item_block_classname = 'wp-block-image size-large';

	/**
	 * Create a Gallery block.
	 *
	 * @param  string $content  json encoded list of WP attachment ids.
	 * @param  array  $attrs  All required block attributes.
	 * @param  bool   $render Should this block render (without comments) or serialize.
	 *
	 * @return string The Gutenberg-compatible output.
	 * @throws \JsonException On json_decode error.
	 */
	public static function create( string $content = '', array $attrs = [], bool $render = false ): string {

		$data                    = self::get_data( $attrs );
		$item_html               = self::create_items( json_decode( $content, true, 512, JSON_THROW_ON_ERROR ) );
		$inner_content           = Figure::create( filter_block_kses_value( $item_html, 'post' ), [ 'classname' => $data['attrs']['className'] ] );
		$data['innerContent']    = [ $inner_content ];
		$data['attrs']['linkTo'] = $attrs['link_to'] ?? 'none';

		return parent::return_block_html( $data, $render );

	}

	/**
	 * Return all a collection of Image blocks as html string.
	 *
	 * @param  array $attrs WP Attchment ID array.
	 *
	 * @return string
	 */
	public static function create_items( array $attrs ): string {

		$rtn = '';
		foreach ( $attrs as $image ) {

			$image_id = isset( $image['id'] ) ? (string) $image['id'] : '';

			$rtn .= CoreImage::create(
				$image_id,
				[
					'attrs' => [
						'url'        => $image['url'] ?? '',
						'alt'        => $image['alt_text'] ?? '',
						'figcaption' => $image['caption'] ?? '',
						'className'  => self::$item_block_classname,
					],
				]
			);
		}

		return $rtn;

	}


}
