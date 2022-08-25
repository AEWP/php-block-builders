<?php
/**
 * Class CoreTable
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;
use PhpBlockBuilders\Element\Figure;

/**
 * Class CoreTable
 *
 * @package PhpBlockBuilders\Block
 */
class CoreTable extends BlockBase {

	/**
	 * The container block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'core/table';

	/**
	 * The block classname.
	 *
	 * @var string
	 */
	public static string $block_classname = 'wp-block-table';

	/**
	 * Create a Core Table Block
	 *
	 * @param  string $content Table content as json string.
	 * @param  array  $attrs Block attributes.
	 * @param  bool   $render Should this block render (without comments) or serialize.
	 *
	 * @return string
	 */
	public static function create( string $content = '', array $attrs = [], bool $render = false ): string {

		$data = self::get_data( $attrs );

		$table_content = self::create_items( json_decode( $content, true, 512, JSON_THROW_ON_ERROR ) );
		$inner_content = Figure::create(
			$table_content,
			[
				'classname'  => \esc_attr( $data['attrs']['className'] ),
				'figcaption' => $attrs['figcaption'] ?? '',
			]
		);

		$data['innerContent'] = [ $inner_content ];

		return parent::return_block_html( $data, $render );

	}


	/**
	 * Table outline as an array - ['header' => [1,2,3], 'footer' => [1,2,3], 'body => [ [1,2,3], [1,2,3] ] ].
	 *
	 * @param  array $attrs Table array.
	 *
	 * @return string
	 */
	public static function create_items( array $attrs ): string {

		$header = $attrs['header'] ?? [];
		$footer = $attrs['footer'] ?? [];
		$body   = $attrs['body'] ?? [];

		$header_html = '';
		$footer_html = '';
		$body_html   = '';

		if ( ! empty( $header ) ) {
			$header_html = '<thead><tr>';
			foreach ( $header as $h ) {
				$header_html .= '<th>' . $h . '</th>';
			}
			$header_html .= '</tr></thead>';
		}

		if ( ! empty( $footer ) ) {
			$footer_html = '<tfoot><tr>';
			foreach ( $footer as $f ) {
				$footer_html .= '<td>' . $f . '</td>';
			}
			$footer_html .= '</tr></tfoot>';
		}

		if ( ! empty( $body ) ) {
			$body_html = '<tbody>';
			foreach ( $body as $row ) {
				$body_html .= '<tr>';
				foreach ( $row as $d ) {
					$body_html .= '<td>' . $d . '</td>';
				}
				$body_html .= '</tr>';
			}
			$body_html .= '</tbody>';
		}

		$template = <<<'TEMPLATE'
			<table>
			%1$s
			%2$s
			%3$s
			</table>
			TEMPLATE;

		return sprintf(
			$template,
			filter_block_kses_value( $header_html, 'post' ),
			filter_block_kses_value( $body_html, 'post' ),
			filter_block_kses_value( $footer_html, 'post' )
		);

	}

}
