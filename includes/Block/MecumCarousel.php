<?php
/**
 * Class MecumCarousel
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;

/**
 * Class MecumCarousel
 *
 * @package PhpBlockBuilders\Block
 */
class MecumCarousel extends BlockBase {

	/**
	 * The block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'mecum/carousel';

	/**
	 * The block classname.
	 *
	 * @var string
	 */
	public static string $block_classname = 'wp-block-mecum-carousel';

	/**
	 * Item block name
	 *
	 * @var string The item block name.
	 */
	public static string $item_block_name = 'mecum/carousel-item';

	/**
	 * Item block classname
	 *
	 * @var string The item block classname.
	 */
	public static string $item_block_classname = 'wp-block-mecum-carousel-item';

	/**
	 * Create a Mecum Carousel Block
	 *
	 * @param  string $content  The carousel content.
	 * @param  array  $attrs  Block attributes.
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
			$items_html // 2
		);

		$data['innerContent'] = [ $inner_content ];

		return serialize_block( $data );
	}

	/**
	 * Create all the carousel items.
	 *
	 * @param  array $attrs  Array of carousel item content. [[ 'item_id' => 0, 'content'=> 'all carousel block items html', 'attrs' => [] ].
	 *
	 * @return string
	 */
	public static function create_items( array $attrs ): string {

		$rtn = '';

		if ( empty( $attrs ) ) {
			return $rtn;
		}

		$block_template = <<<'TEMPLATE'
		<div class="%1$s">%2$s</div>
		TEMPLATE;

		foreach ( $attrs as $item ) {

			$image   = CoreImage::create( (string) $item['image_id'] );
			$content = $item['content'] ?? '';

			$inner_content = sprintf(
				$block_template,
				\esc_attr( self::$item_block_classname ), // 1
				$image . $content // 2
			);

			$data = [
				'blockName'    => self::$item_block_name,
				'innerContent' => [ $inner_content ],
				'attrs'        => $item['attrs'] ?? [],
			];

			$rtn .= serialize_block( $data );

		}

		return $rtn;

	}


}
