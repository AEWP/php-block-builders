<?php
/**
 * PHP Block Builders
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;


/**
 * Core List Gutenberg block.
 *
 * @package PhpBlockBuilders\Block
 */
class CoreList extends BlockBase {

	/**
	 * The container block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'core/list';

	/**
	 * The block classname.
	 *
	 * @var string
	 */
	public static string $block_classname = '';

	/**
	 * Create a list block from json encoded content array for items.
	 *
	 * @param  string $content  json encoded list items string.
	 * @param  array  $attrs  All required block attributes.
	 * @param  bool   $render Should this block render (without comments) or serialize.
	 *
	 * @return string The Gutenberg-compatible output.
	 * @throws \JsonException On json_decode error.
	 */
	public static function create( string $content = '', array $attrs = [], bool $render = false ): string {

		$data       = self::get_data( $attrs );
		$items_html = self::create_items( json_decode( $content, true, 512, JSON_THROW_ON_ERROR ) );
		$type       = $attrs['type'] ?? 'unordered';

		$block_template = <<<'TEMPLATE'
		<%1$s>%2$s</%1$s>
		TEMPLATE;

		$inner_content = sprintf(
			$block_template,
			( $type === 'ordered' ) ? 'ol' : 'ul', // 1
			\filter_block_kses_value( $items_html, 'post' ) // 2
		);

		$data['innerContent']     = [ $inner_content ];
		$data['attrs']['ordered'] = 'ordered' === $type;

		return parent::return_block_html( $data, $render );

	}

	/**
	 * Create all the list items.
	 *
	 * @param  array $attrs  Array of list item content.
	 *
	 * @return string
	 */
	public static function create_items( array $attrs ): string {
		$rtn = '';

		if ( empty( $attrs ) ) {
			return '<li></li>';
		}

		foreach ( $attrs as $li ) {
			$rtn .= '<li>' . $li . '</li>';
		}

		return $rtn;

	}


}
