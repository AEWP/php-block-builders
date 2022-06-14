<?php
/**
 * PHP Block Builders
 *
 * @package PhpBlockBuilders\Blocks
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Blocks;

use PhpBlockBuilders\BlockBase;

/**
 * Core List Gutenberg block.
 *
 * @package PhpBlockBuilders\Blocks
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

		$attrs     = self::get_attributes( $attrs );
		$list_html = self::create_items( json_decode( $content, true, 512, JSON_THROW_ON_ERROR ) );
		$type      = $attrs['type'] ?? 'unordered';

		$inner_content = sprintf(
			'<%1$s>%2$s</%1$s>',
			( $type === 'ordered' ) ? 'ol' : 'ul', // 1
			\filter_block_kses_value( $list_html, 'post' ) // 2
		);

		$data = [
			'blockName'    => $attrs['block_name'],
			'innerContent' => [ $inner_content ],
			'attrs'        => [
				'ordered' => 'ordered' === $type,
				'lock'    => [
					'move'   => $attrs['lock_move'],
					'remove' => $attrs['remove'],
				],
			],
		];

		return serialize_block( $data );

	}

	/**
	 * Create all the list items.
	 *
	 * @param  array $items Array of list item content.
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
