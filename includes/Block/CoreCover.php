<?php
/**
 * Class CoreCover
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;
use PhpBlockBuilders\Element\Image;

/**
 * Class CoreHtml
 *
 * @package PhpBlockBuilders\Block
 */
class CoreCover extends BlockBase {

	/**
	 * The container block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'core/cover';

	/**
	 * The block classname.
	 *
	 * @var string
	 */
	public static string $block_classname = 'wp-block-cover';

	/**
	 * Create a Core Cover Block
	 *
	 * @param  string $content  Any cover block content text content (as blocks).
	 * @param  array  $attrs  Block attributes ['id' => 'WP Attachment ID', 'dim_ratio' => 'dimRatio', 'object_fit' => 'image data object fit'].
	 *
	 * @return string
	 */
	public static function create( string $content = '', array $attrs = [] ): string {

		$data                  = self::get_data( $attrs );
		$image_id              = absint( $attrs['id'] );
		$dim_ratio             = $attrs['attrs']['dimRatio'] ?? 56;
		$dim_ratio_closest_ten = ceil( $dim_ratio / 10 ) * 10;
		$image                 = Image::create(
			$image_id,
			[
				'classname'   => sprintf( 'wp-block-cover__image-background wp-image-%s', $image_id ),
				'image_attrs' => [ 'data-object-fit' => $attrs['object_fit'] ?? 'cover' ],
			]
		);

		$block_template = <<<'TEMPLATE'
		<div class="%1$s">
			<span aria-hidden="true" class="wp-block-cover__background has-background-dim-%2$s has-background-dim"></span>
			%3$s
			<div class="wp-block-cover__inner-container">
			%4$s
		</div></div>
		TEMPLATE;

		$inner_content = sprintf(
			$block_template,
			\esc_attr( $data['attrs']['className'] ), // 1
			\absint( $dim_ratio_closest_ten ), // 2
			$image['image_html'], // 3
			\filter_block_kses_value( $content, 'post' ) // 4
		);

		$data['innerContent']      = [ $inner_content ];
		$data['attrs']['dimRatio'] = $dim_ratio;
		$data['attrs']['id']       = $image_id;
		$data['attrs']['url']      = $image['attrs']['mediaLink'];

		return serialize_block( $data );

	}


}
