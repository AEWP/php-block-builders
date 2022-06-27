<?php
/**
 * PHP Block Builders
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;
use PhpBlockBuilders\Element\Image;

use function esc_attr;
use function filter_block_kses_value;

/**
 * Core Media & Text Gutenberg block.
 *
 * @package PhpBlockBuilders\Block
 */
class CoreMediaText extends BlockBase {

	/**
	 * The container block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'core/media-text';


	/**
	 * The block classname.
	 *
	 * @var string
	 */
	public static string $block_classname = 'wp-block-media-text';

	/**
	 * Convert Salesforce text to Gutenberg equivalent.
	 *
	 * @param  string $content  String text/html/url content.
	 * @param  array  $attrs  All required block attributes.
	 *
	 * @return string The Gutenberg-compatible output.
	 */
	public static function create( string $content = '', array $attrs = [] ): string {

		$data = self::get_data( $attrs );

		$image_id       = $attrs['image_id'] ?? 0;
		$media_position = $attrs['media_position'] ?? 'right';
		$image          = Image::create( absint( $image_id ) );
		$image_html     = $image['image_html'];

		$block_template = <<<'TEMPLATE'
		<div class="%1$s alignwide %2$s is-stacked-on-mobile">
		<figure class="%1$s__media">%3$s</figure>
		<div class="%1$s__content">
		%4$s
		</div>
		</div>
		TEMPLATE;

		$inner_content = sprintf(
			$block_template,
			\esc_attr( $data['attrs']['className'] ), // 1
			$media_position === 'right' ? esc_attr( "has-media-on-the-{$media_position}" ) : '', // 2
			$image_html, // 3
			filter_block_kses_value( CoreParagraph::create( $content ), 'post' ) // 4
		);

		$data['innerContent']       = [ $inner_content ];
		$data['attrs']['mediaId']   = $image['attrs']['mediaId'] ?? '';
		$data['attrs']['mediaLink'] = $image['attrs']['mediaLink'] ?? '';
		$data['attrs']['mediaType'] = 'image';
		if ( $media_position === 'right' ) {
			$data['attrs']['mediaPosition'] = $media_position;
		}

		return serialize_block( $data );

	}


}
