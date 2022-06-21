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
	 * Create a Core Cover Block
	 *
	 * @param  string $content  Any cover block content text content (as blocks).
	 * @param  array  $attrs  Block attributes ['id' => 'WP Attachment ID', 'dim_ratio' => 'dimRatio', 'object_fit' => 'image data object fit'].
	 *
	 * @return string
	 */
	public static function create( string $content = '', array $attrs = [] ): string {

		$attrs     = self::get_block_attrs( $attrs );
		$image_id  = absint( $attrs['id'] );
		$image     = Image::create(
			$image_id,
			[
				'classname'   => sprintf( 'wp-block-cover__image-background wp-image-%s', $image_id ),
				'image_attrs' => [ 'data-object-fit' => $attrs['object_fit'] ?? 'cover' ],
			]
		);
		$classname = $attrs['classname'] ?? 'wp-block-cover';
		$dim_ratio = $attrs['dim_ratio'];

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
			\esc_attr( $classname ), // 1
			\absint( $dim_ratio ), // 2
			$image['image_html'], // 3
			\filter_block_kses_value( $content, 'post' ), // 4
		);

		$data = self::get_data(
			$attrs,
			[ trim( $inner_content ) ],
			[
				'attrs' => [
					'id'       => $image_id,
					'url'      => $image['attrs']['mediaLink'],
					'dimRatio' => \absint( $dim_ratio ),
				],

			]
		);

		return serialize_block( $data );

	}


}
