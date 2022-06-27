<?php
/**
 * Class MecumBanner
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;

/**
 * Class MecumBanner
 *
 * @package PhpBlockBuilders\Block
 */
class MecumBanner extends BlockBase {

	/**
	 * The block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'mecum/banner';

	/**
	 * The block classname.
	 *
	 * @var string
	 */
	public static string $block_classname = 'wp-block-mecum-banner has-black-background-color has-background';

	/**
	 * Create a Mecum Banner Block
	 *
	 * @param  string $content The banner content.
	 * @param  array  $attrs Block attributes.
	 *
	 * @return string
	 */
	public static function create( string $content = '', array $attrs = [] ): string {

		$data             = self::get_data( $attrs );
		$background_color = $attrs['background_color'] ?? '#000000';

		// 1st column
		$image      = CoreImage::create( (string) $attrs['image_id'] );
		$column_one = CoreColumn::create(
			$image,
			[
				'attrs' => [
					'className'         => 'wp-block-column is-vertically-aligned-center',
					'verticalAlignment' => 'center',
					'width'             => '20%',
					'style'             => 'flex-basis:20%',
				],
			]
		);

		// 2nd columns
		$paragraph   = CoreParagraph::create(
			$content ?? '',
			[
				'attrs' => [
					'className'    => 'has-white-color has-text-color',
					'textColor'    => 'white',
					'textColorHex' => '#ffffff',
				],
			]
		);
		$columns_two = CoreColumn::create(
			$paragraph,
			[
				'attrs' => [
					'className'         => 'wp-block-column is-vertically-aligned-center',
					'verticalAlignment' => 'center',
					'width'             => '20%',
					'style'             => 'flex-basis:20%',
				],
			]
		);

		// 2 columns
		$inner_content = CoreColumns::create(
			$column_one . $columns_two,
			[
				'attrs' => [
					'className'         => 'wp-block-columns are-vertically-aligned-center',
					'isStackedOnMobile' => 'false',
					'verticalAlignment' => 'center',
				],
			]
		);

		$block_template = <<<'TEMPLATE'
		<div class="%1$s">%2$s</div>
		TEMPLATE;

		$inner_content = sprintf(
			$block_template,
			\esc_attr( $data['attrs']['className'] ), // 1
			$inner_content, // 2
		);

		$data['innerContent']                = [ $inner_content ];
		$data['attrs']['backgroundColorHex'] = $background_color;

		return serialize_block( $data );

	}


}
