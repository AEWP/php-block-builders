<?php
/**
 * PHP Block Builders
 *
 * @package PhpBlockBuilders\Blocks
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Blocks;

use PhpBlockBuilders\BlockBase;
use PhpBlockBuilders\Elements\Image;

/**
 * Core Media & Text Gutenberg block.
 *
 * @package PhpBlockBuilders\Blocks
 */
class CoreMediaText extends BlockBase {

	/**
	 * The container block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'core/media-text';

	/**
	 * Convert Salesforce text to Gutenberg equivalent.
	 *
	 * @param  string $content String text/html/url content.
	 * @param  array  $attrs All required block attributes.
	 *
	 * @return string The Gutenberg-compatible output.
	 */
	public static function create( string $content = '', array $attrs = [] ): string {

		$attrs = self::get_attributes( $attrs );

		$image_id       = $attrs['image_id'] ?? 0;
		$media_position = $attrs['media_position'] ?? 'right';

		$block_attrs = [
			'lock' => [
				'move'   => true,
				'remove' => true,
			],
		];

		if ( $media_position === 'right' ) {
			$block_attrs['mediaPosition'] = $media_position;
		}

		$image       = Image::create( absint( $image_id ) );
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
			\filter_block_kses_value( CoreParagraph::create( $content ), 'post' ) // 3
		);

		$data = [
			'blockName'    => $attrs['block_name'],
			'innerContent' => [ $inner_content ],
			'attrs'        => $block_attrs,
		];

		return serialize_block( $data );

	}


}
