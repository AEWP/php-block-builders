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
	 *
	 * @return string The converted Gutenberg-compatible output.
	 */
	public static function create( string $content = '', array $attrs = [] ): string {
		$data     = self::get_data( $attrs );
		$image_id = absint( $content );
		$image    = Image::create(
			$image_id,
			[
				'classname' => $data['image_class'] ?? '',
				'url'       => $data['attrs']['url'] ?? '',
				'alt'       => $data['attrs']['alt'] ?? '',
			]
		);

		$inner_content = Figure::create(
			$image['image_html'],
			[
				'classname'  => $data['attrs']['className'],
				'figcaption' => $data['caption'] ?? '',
			]
		);

		$data['innerContent']       = [ $inner_content ];
		$data['attrs']['className'] = $data['attrs']['className'] ?? 'size-large';
		$data['attrs']['mediaId']   = $image_id;
		$data['attrs']['mediaLink'] = $image['attrs']['mediaLink'];
		$data['attrs']['mediaType'] = $data['attrs']['mediaType'] ?? 'image';

		return serialize_block( $data );
	}


}
