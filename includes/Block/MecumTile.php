<?php
/**
 * Class MecumTile
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;

/**
 * Class MecumTile
 *
 * @package PhpBlockBuilders\Block
 */
class MecumTile extends BlockBase {

	/**
	 * The block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'mecum/tile';

	/**
	 * The block classname.
	 *
	 * @var string
	 */
	public static string $block_classname = 'wp-block-mecum-tile';

	/**
	 * Create a Mecum Tile Block
	 *
	 * @param  string $content  The tile content array as json string.
	 * ['title' => 'title', 'paragraph' => 'paragraph', 'image_id' => '0' ].
	 *
	 * @param  array  $attrs  Block attributes. ['attrs' => ['url' => 'link', 'linkText] => 'link text' ] ].
	 *
	 * @return string
	 * @throws \JsonException On json decode error.
	 */
	public static function create( string $content = '', array $attrs = [] ): string {

		$data       = self::get_data( $attrs );
		$items_html = self::create_items( json_decode( $content, true, 512, JSON_THROW_ON_ERROR ) );

		$block_template = <<<'TEMPLATE'
		<div class="%1$s">%2$s</div>
		TEMPLATE;

		$inner_content = sprintf(
			$block_template,
			\esc_attr( $data['attrs']['className'] ), // 1
			$items_html, // 2
		);

		$data['innerContent'] = [ $inner_content ];

		return serialize_block( $data );

	}

	/**
	 * Create the items html from the items array.
	 *
	 * @param  array $attrs  Content array.
	 *
	 * @return string
	 */
	public static function create_items( array $attrs ): string {
		$rtn = '';

		if ( empty( $attrs ) ) {
			return $rtn;
		}

		$rtn .= CoreImage::create( $attrs['image_id'] ?? '', [ 'attrs' => [ 'className' => 'wp-block-image size-large tile__image' ] ] );

		// Create the main title and paragraph.
		$rtn .= CoreHeading::create(
			$attrs['title'] ?? '',
			[
				'level' => 3,
			]
		);
		$rtn .= CoreParagraph::create( $attrs['paragraph'] ?? '' );

		return $rtn;

	}
}
