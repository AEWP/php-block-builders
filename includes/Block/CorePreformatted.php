<?php
/**
 * Class CorePreformatted
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;

/**
 * Class CorePreformatted
 *
 * @package PhpBlockBuilders\Block
 */
class CorePreformatted extends BlockBase {

	/**
	 * The container block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'core/preformatted';

	/**
	 * The block classname.
	 *
	 * @var string
	 */
	public static string $block_classname = 'wp-block-preformatted';

	/**
	 * Create a Core Code Block
	 *
	 * @param  string $content The code text.
	 * @param  array  $attrs Block attributes.
	 * @param  bool   $render Should this block render (without comments) or serialize.
	 *
	 * @return string
	 */
	public static function create( string $content = '', array $attrs = [], bool $render = false ): string {

		$data = self::get_data( $attrs );

		$block_template = <<<'TEMPLATE'
		<pre class="%1$s">%2$s</pre>
		TEMPLATE;

		$inner_content = sprintf(
			$block_template,
			\esc_attr( $data['attrs']['className'] ), // 1
			\filter_block_kses_value( $content, 'post' ) // 2
		);

		$data['innerContent'] = [ $inner_content ];

		return parent::return_block_html( $data, $render );

	}


}
