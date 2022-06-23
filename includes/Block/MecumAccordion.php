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
	 * Create the accordion block
	 *
	 * @param  string $content Json encoded array of all of the accordion items.
	 * @param  array  $attrs Container attributes.
	 *
	 * @return string
	 * @throws \JsonException On json_decode error.
	 */
	public static function create( string $content = '', array $attrs = [] ): string {

		$attrs      = self::get_block_attrs( $attrs );
		$classname  = $attrs['classname'] ?? 'wp-block-mecum-accordion';
		$items_html = self::create_items( json_decode( $content, true, 512, JSON_THROW_ON_ERROR ) );

		$block_template = <<<'TEMPLATE'
		<div class="%1$s">
		%2$s
		</div>
		TEMPLATE;

		$inner_content = sprintf(
			$block_template,
			\esc_attr( $classname ), // 1
			filter_block_kses_value( $items_html, 'post' ) // 2
		);

		$data = self::get_data(
			$attrs,
			[ $inner_content ]
		);

		return serialize_block( $data );
	}


	/**
	 * Create each accordion item
	 *
	 * @param  array $attrs Each accordion item title and content. ['title' => 'title', 'body' => 'body', 'open' => true].
	 *
	 * @return string
	 */
	public static function create_items( array $attrs ): string {

		$rtn       = '';
		$classname = $attrs['classname'] ?? 'wp-block-mecum-accordion-item';

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
					esc_attr( $classname ),
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

