<?php
/**
 * Class MecumExpandShowMore
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;

/**
 * Class MecumExpandShowMore
 *
 * @package PhpBlockBuilders\Block
 */
class MecumExpandShowMore extends BlockBase {


	/**
	 * The block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'mecum/expand-show-more';

	/**
	 * The block classname.
	 *
	 * @var string
	 */
	public static string $block_classname = 'wp-block-mecum-expand-show-more';


	/**
	 * Create a Mecum Newsletter CTA Block
	 *
	 * @param  string $content  Content array as a json string.
	 * @param  array  $attrs  Block attributes.
	 * @param  bool   $render  Should this block render (without comments) or serialize.
	 *
	 * @return string
	 * @throws \JsonException If json decode error.
	 */
	public static function create( string $content = '', array $attrs = [], bool $render = false ): string {

		$data             = self::get_data( $attrs );
		$items_html       = json_decode( $content, true, 512, JSON_THROW_ON_ERROR );
		$insert_read_more = \absint( $data['insertReadMore'] ) ?? 2;

		// This block only allows for paragraph blocks and read me.
		foreach ( $items_html as $k => $v ) {
			$items_html[ $k ] = CoreParagraph::create( wp_strip_all_tags( $v ) );
		}

		// Only insert read more if more content blocks than $insert_read_more count.
		if ( count( $items_html ) > $insert_read_more ) {
			array_splice( $items_html, $insert_read_more, 0, CoreReadMore::create( '' ) );
		}

		$block_template = <<<'TEMPLATE'
		<div class="%1$s">%2$s</div>
		TEMPLATE;

		$inner_content = sprintf(
			$block_template,
			self::get_element_classname( $data ), // 1
			implode( PHP_EOL, $items_html ) // 2
		);

		$data['innerContent'] = [ $inner_content ];

		return parent::return_block_html( $data, $render );

	}


}
