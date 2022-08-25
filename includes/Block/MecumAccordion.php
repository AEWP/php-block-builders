<?php
/**
 * Class MecumAccordion
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;

/**
 * Class MecumAccordion
 *
 * @package PhpBlockBuilders\Block
 */
class MecumAccordion extends BlockBase {

	/**
	 * The container block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'mecum/accordion';

	/**
	 * Optional item block name.
	 *
	 * @var string
	 */
	public static string $item_block_name = 'mecum/accordion-item';

	/**
	 * The block classname.
	 *
	 * @var string
	 */
	public static string $block_classname = 'wp-block-mecum-accordion';


	/**
	 * The items block classname.
	 *
	 * @var string
	 */
	public static string $item_block_classname = 'wp-block-mecum-accordion-item';

	/**
	 * Create the accordion block
	 *
	 * @param  string $content Json encoded array of all of the accordion items.
	 * @param  array  $attrs Container attributes.
	 * @param  bool   $render Should this block render (without comments) or serialize.
	 *
	 * @return string
	 * @throws \JsonException On json_decode error.
	 */
	public static function create( string $content = '', array $attrs = [], bool $render = false ): string {

		$data       = self::get_data( $attrs );
		$items_html = self::create_items( json_decode( $content, true, 512, JSON_THROW_ON_ERROR ) );

		$block_template = <<<'TEMPLATE'
		<div class="%1$s">
		%2$s
		</div>
		TEMPLATE;

		$inner_content = sprintf(
			$block_template,
			\esc_attr( $data['attrs']['className'] ), // 1
			filter_block_kses_value( $items_html, 'post' ) // 2
		);

		$data['innerContent'] = [ $inner_content ];

		return parent::return_block_html( $data, $render );
	}


	/**
	 * Create each accordion item
	 *
	 * @param  array $attrs Each accordion item title and content. ['title' => 'title', 'body' => 'body', 'open' => true].
	 *
	 * @return string
	 */
	public static function create_items( array $attrs ): string {

		$rtn = '';

		$block_template = <<<'TEMPLATE'
		<div class="%1$s">
		<h2>%2$s</h2>
		<p>%3$s</p>
		</div>
		TEMPLATE;

		if ( ! empty( $attrs ) ) {
			foreach ( $attrs as $item ) {

				$inner_content = sprintf(
					$block_template,
					esc_attr( self::$item_block_classname ),
					esc_html( $item['title'] ?? '' ),
					filter_block_kses_value( $item['body'], 'post' )
				);

				$data = [
					'blockName'    => self::$item_block_name,
					'innerContent' => [ $inner_content ],
					'attrs'        => [
						'title' => $item['title'] ?? '',
						'body'  => $item['body'] ?? '',
						'open'  => $item['open'] ?? false,
					],
				];

				$rtn .= serialize_block( $data );

			}
		}

		return $rtn;
	}

}

