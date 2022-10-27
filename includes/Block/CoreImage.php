<?php
/**
 * PHP Block Builders
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;
use PhpBlockBuilders\Element\Figure;
use PhpBlockBuilders\Element\Image;

/**
 * Core Image Gutenberg block.
 *
 * @package PhpBlockBuilders\Block
 */
class CoreImage extends BlockBase {

	/**
	 * The container block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'core/image';

	/**
	 * The container block classname.
	 *
	 * @var string
	 */
	public static string $block_classname = 'wp-block-image';


	/**
	 * Creates a Core Image Block.
	 *
	 * @param  string $content  Image id.
	 * @param  array  $attrs  All required block attributes.
	 * @param  bool   $render Should this block render (without comments) or serialize.
	 *
	 * @return string The converted Gutenberg-compatible output.
	 */
	public static function create( string $content = '', array $attrs = [], bool $render = false ): string {
		$data     = self::get_data( $attrs );
		$image_id = absint( $content );
		$image    = Image::create(
			$image_id,
			[
				'classname' => $data['image_class'] ?? '',
				'url'       => $data['attrs']['url'] ?? '',
				'alt'       => $data['attrs']['alt'] ?? ( get_post_meta( $image_id, '_wp_attachment_image_alt', true ) ?? '' ),
			]
		);

		$inner_content = Figure::create(
			$image['image_html'],
			[
				'classname'  => $data['attrs']['className'],
				'figcaption' => $data['attrs']['figcaption'] ?? '',
			]
		);

		$data['innerContent']       = [ $inner_content ];
		$data['attrs']['className'] = $data['attrs']['className'] ?? 'size-large';
		$data['attrs']['mediaId']   = $image_id;
		$data['attrs']['mediaLink'] = $image['attrs']['mediaLink'];
		$data['attrs']['mediaType'] = $data['attrs']['mediaType'] ?? 'image';

		return parent::return_block_html( $data, $render );
	}


}
