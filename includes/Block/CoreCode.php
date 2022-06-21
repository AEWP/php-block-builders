<?php
/**
 * Class CoreCode
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;

/**
 * Class CoreCode
 *
 * @package PhpBlockBuilders\Block
 */
class CoreCode extends BlockBase {

	/**
	 * The container block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'core/code';

	/**
	 * Create a Core Code Block
	 *
	 * @param  string $content The code text.
	 * @param  array  $attrs Block attributes.
	 *
	 * @return string
	 */
	public static function create( string $content = '', array $attrs = [] ): string {

		$attrs     = self::get_block_attrs( $attrs );
		$classname = $attrs['classname'] ?? 'wp-block-code';

		$block_template = <<<'TEMPLATE'
		<pre class="%1$s">
			<code>%2$s</code>
		</pre>
		TEMPLATE;

		$inner_content = sprintf(
			$block_template,
			\esc_attr( $classname ), // 1
			\filter_block_kses_value( $content, 'post' ), // 2
		);

		$data = self::get_data(
			$attrs,
			[ trim( $inner_content ) ]
		);

		return serialize_block( $data );

	}


}
