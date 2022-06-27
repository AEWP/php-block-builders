<?php
/**
 * Class MecumCallToAction
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;

/**
 * Class MecumCallToAction
 *
 * @package PhpBlockBuilders\Block
 */
class MecumCallToAction extends BlockBase {

	/**
	 * The container block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'mecum/call-to-action';

	/**
	 * The block classname.
	 *
	 * @var string
	 */
	public static string $block_classname = 'wp-block-mecum-call-to-action';

	/**
	 * Create a Mecum Call to Action block
	 *
	 * @param  string $content
	 * @param  array  $attrs
	 *
	 * @return string
	 */
	public static function create( string $content = '', array $attrs = [] ): string {

		$heading   = CoreHeading::create(
			'Call to Action',
			[
				'level' => 2,
			]
		);
		$paragraph = CoreParagraph::create( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec euismod, nisl eget consectetur consectetur, nisi nisl consectetur nisi, euismod consectetur nisi nisi euismod nisi.' );
		$button    = CoreButton::create( 'hola' );
		$buttons   = CoreButtons::create( $button );

		$cover = CoreCover::create( $heading . $paragraph . $buttons, [ 'id' => 5 ] );

		$data           = self::get_data( $attrs );
		$block_template = <<<'TEMPLATE'
		<div class="%1$s">
		%2$s
		</div>
		TEMPLATE;

		$inner_content = sprintf(
			$block_template,
			\esc_attr( $data['attrs']['className'] ), // 1
			$cover // 2
		);

		$data['innerContent'] = [ $inner_content ];

		return serialize_block( $data );

	}


}
