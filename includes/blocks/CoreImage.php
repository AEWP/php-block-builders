<?php
/**
 * PHP Block Builders
 *
 * @package PhpBlockBuilders\Blocks
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Blocks;

use PhpBlockBuilders\BlockBase;
use PhpBlockBuilders\Elements\Figure;
use PhpBlockBuilders\Elements\Image;

/**
 * Core Image Gutenberg block.
 *
 * @package PhpBlockBuilders\Blocks
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
	 * @param  string $content Image id.
	 * @param  array  $attrs All required block attributes.
	 *
	 * @return string The converted Gutenberg-compatible output.
	 */
	public static function create( string $content = '', array $attrs = [] ): string {

		$attrs     = self::get_attributes( $attrs );
		$image_id  = absint( $content );
		$classname = $attrs['classname'] ?? 'wp-block-image size-large';
		$image     = Image::create( $image_id, [ 'classname' => $classname ] );

		if ( empty( $image['image_html'] ) ) {
			return '';
		}

		$inner_content = Figure::create( $image['image_html'], [ 'classname' => $classname ] );

		$data = [
			'blockName'    => $attrs['block_name'],
			'innerContent' => [ $inner_content ],
			'attrs'        => [
				'mediaId'   => $image_id,
				'mediaLink' => $image['attrs']['mediaLink'],
				'mediaType' => 'image',
			],
		];

		return serialize_block( $data );
	}


}
