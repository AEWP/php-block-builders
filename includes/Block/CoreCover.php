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
 * Class CoreCover
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
	 * @param  array  $attrs  Block attributes ['attrs' => [ 'id' => 'WP Attachment ID', 'dim_ratio' => 'dimRatio', 'object_fit' =>
	 *     'image data object fit'] ].
	 * @param  bool   $render Should this block render (without comments) or serialize.
	 *
	 * @return string
	 */
	public static function create( string $content = '', array $attrs = [], bool $render = false ): string {
		$data                  = self::get_data( $attrs );
		$image                 = null;
		$image_id              = absint( $attrs['attrs']['id'] ?? 0 );
		$dim_ratio             = $attrs['attrs']['dimRatio'] ?? 50;
		$dim_ratio_closest_ten = ceil( $dim_ratio / 10 ) * 10;
		$block_class           = [ $data['attrs']['className'] ];
		$span_class            = $attrs['span_class'] ?? 'has-background-dim-' . $dim_ratio_closest_ten . ' wp-block-cover__gradient-background has-background-dim';

		$style = $attrs['attrs']['minHeight'] ? "min-height:{$attrs['attrs']['minHeight']}{$attrs['attrs']['minHeightUnit']}" : '';

		if ( isset( $attrs['attrs']['align'] ) ) {
			$block_class[] = "align{$attrs['attrs']['align']}";
		}

		if ( $image_id > 0 ) {
			$image = Image::create(
				$image_id,
				[
					'classname'   => sprintf( 'wp-block-cover__image-background wp-image-%s', $image_id ),
					'image_attrs' => [ 'data-object-fit' => $attrs['object_fit'] ?? 'cover' ],
					'url'         => $data['attrs']['url'] ?? '',
					'alt'         => $data['attrs']['alt'] ?? '',
				]
			);
		}

		$block_template = <<<'TEMPLATE'
		<div class="%1$s" style="%2$s">
			<span aria-hidden="true" class="%3$s"></span>
			%4$s
			<div class="wp-block-cover__inner-container">
			%5$s
		</div></div>
		TEMPLATE;

		$inner_content = sprintf(
			$block_template,
			\esc_attr( join( ' ', $block_class ) ), // 1
			\esc_attr( $style ), // 2
			$span_class, // 3
			$image['image_html'] ?? '', // 4
			\filter_block_kses_value( $content, 'post' ) // 5
		);

		$data['innerContent']      = [ $inner_content ];
		$data['attrs']['dimRatio'] = $dim_ratio;
		if ( 0 === $image_id ) {
			unset( $data['attrs']['id'], $data['attrs']['className'] );
		}

		$data['attrs']['url'] = $image['attrs']['mediaLink'] ?? '';

		return parent::return_block_html( $data, $render );

	}


}
