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
	 * @param  string $content  Json encoded string from array.
	 * ['image_id' => 0, 'heading' => 'text', 'paragraph' => 'text', 'button'=> ['text' => 'text', 'href'=> 'url', 'target' => '' ].
	 * @param  array  $attrs  Block attributes.
	 * @param  bool   $render Should this block render (without comments) or serialize.
	 *
	 * @return string
	 * @throws \JsonException On json decode error.
	 */
	public static function create( string $content = '', array $attrs = [], bool $render = false ): string {

		$data       = self::get_data( $attrs );
		$items_html = self::create_items( json_decode( $content, true, 512, JSON_THROW_ON_ERROR ) );

		$block_template = <<<'TEMPLATE'
		<div class="%1$s">
		%2$s
		</div>
		TEMPLATE;

		$inner_content = sprintf(
			$block_template,
			\esc_attr( $data['attrs']['className'] ), // 1
			$items_html // 2
		);

		$data['innerContent'] = [ $inner_content ];

		return parent::return_block_html( $data, $render );

	}

	/**
	 * Create the items for the block.
	 *
	 * @param  array $attrs  The items to create.
	 *
	 * @return string The items html.
	 */
	public static function create_items( array $attrs ): string {

		$heading   = CoreHeading::create(
			$attrs['title'] ?? '',
			[
				'level' => 2,
			]
		);
		$paragraph = CoreParagraph::create( $attrs['paragraph'] ?? '' );
		$button    = CoreButton::create( $attrs['button']['text'], $attrs['button'] );
		$buttons   = CoreButtons::create( $button );

		return CoreCover::create( $heading . $paragraph . $buttons, [ 'attrs' => [ 'id' => $attrs['image_id'] ] ] );

	}


}
