<?php
/**
 * PHP Block Builders
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;

use function filter_block_kses_value;

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
	 * Create a list block from json encoded content array for items.
	 *
	 * @param  string $content  json encoded list items string.
	 * @param  array  $attrs  All required block attributes.
	 *
	 * @return string The Gutenberg-compatible output.
	 * @throws \JsonException On json_decode error.
	 */
	public static function create( string $content = '', array $attrs = [] ): string {
		$attrs     = self::get_block_attrs( $attrs );
		$items_html = self::create_items( json_decode( $content, true, 512, JSON_THROW_ON_ERROR ) );
		$type      = $attrs['type'] ?? 'unordered';

		$inner_content = sprintf(
			'<%1$s>%2$s</%1$s>',
			( $type === 'ordered' ) ? 'ol' : 'ul', // 1
			filter_block_kses_value( $items_html, 'post' ) // 2
		);

		$data = self::get_data(
			$attrs,
			[ $inner_content ],
			[
				'attrs' => [
					'ordered' => 'ordered' === $type,
				],
			]
		);

		return serialize_block( $data );

	}

	/**
	 * Create all the list items.
	 *
	 * @param  array $items  Array of list item content.
	 *
	 * @return string
	 */
	public static function create_items( array $items ): string {
		$rtn = '';
		if ( ! empty( $items ) ) {
			foreach ( $items as $li ) {
				$rtn .= '<li>' . $li . '</li>';
			}
		}

		return $rtn;

	}


}
