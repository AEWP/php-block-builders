<?php
/**
 * Mecum Salesforce Connector
 *
 * @package PhpBlockBuilders\Blocks
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Blocks;

/**
 * Core List Gutenberg block.
 */
class CoreList {
	/**
	 * Convert Salesforce list to Gutenberg equivalent.
	 *
	 * @param  array  $list  Salesforce list.
	 * @param  string $type The list type.
	 *
	 * @return string The converted Gutenberg-compatible output.
	 */
	public static function convert_to_list_block( array $list, string $type = 'unordered' ): string {

		$list_html = '';
		if ( ! empty( $list ) ) {
			foreach ( $list as $li ) {
				$list_html .= '<li>' . $li . '</li>';
			}
		}

		$inner_content = sprintf(
			'<%1$s>%2$s</%1$s>',
			( $type === 'ordered' ) ? 'ol' : 'ul', // 1
			\filter_block_kses_value( $list_html, 'post' ) // 2
		);

		$data = [
			'blockName'    => 'core/list',
			'innerContent' => [ $inner_content ],
			'attrs'        => [
				'ordered' => 'ordered' === $type,
				'lock'    => [
					'move'   => true,
					'remove' => true,
				],
			],
		];

		return serialize_block( $data );

	}
}
