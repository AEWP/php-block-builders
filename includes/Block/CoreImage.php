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
	 * Creates a Core Image Block.
	 *
	 * @param  string $content  Image id.
	 * @param  array  $attrs  All required block attributes.
	 *
	 * @return string The converted Gutenberg-compatible output.
	 */
	public static function create( string $content = '', array $attrs = [] ): string {
		$attrs         = self::get_block_names( $attrs );
		$image_id      = absint( $content );
		$classname     = $attrs['classname'] ?? 'wp-block-image size-large';
		$image         = Image::create( $image_id, [ 'classname' => $attrs['image_class'] ?? '' ] );
		$inner_content = Figure::create( $image['image_html'], [ 'classname' => $classname ] );

		$data = self::get_data(
			$attrs,
			[ $inner_content ],
			[
				'attrs' => [
					'className' => 'size-large',
					'mediaId'   => $image_id,
					'mediaLink' => $image['attrs']['mediaLink'],
					'mediaType' => 'image',
				],
			]
		);

		return serialize_block( $data );
	}


}
