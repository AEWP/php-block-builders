<?php
/**
 * Class MecumStats
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;

/**
 * Class MecumStats
 *
 * @package PhpBlockBuilders\Block
 */
class MecumStats extends BlockBase {

	/**
	 * The block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'mecum/stats';

	/**
	 * The block classname.
	 *
	 * @var string
	 */
	public static string $block_classname = 'wp-block-mecum-stats';

	/**
	 * Reusable generic center classname
	 */
	private const CENTER_CLASS = 'has-text-align-center';


	/**
	 * Create a Mecum Stats Block
	 *
	 * @param  string $content  The banner content array as json string
	 * ['title' => 'main title', 'paragraph' => 'main paragraph','columns'   => [ ['title' => 'title', 'paragraph' => 'paragraph'], ['title' => 'title', 'paragraph' => 'paragraph' ]]].
	 *
	 * @param  array  $attrs  Block attributes.
	 *
	 * @return string
	 * @throws \JsonException On json decode error.
	 */
	public static function create( string $content = '', array $attrs = [] ): string {

		$data       = self::get_data( $attrs );
		$items_html = self::create_items( json_decode( $content, true, 512, JSON_THROW_ON_ERROR ) );

		$block_template = <<<'TEMPLATE'
		<div class="%1$s">%2$s</div>
		TEMPLATE;

		$inner_content = sprintf(
			$block_template,
			\esc_attr( $data['attrs']['className'] ), // 1
			$items_html, // 2
		);

		$data['innerContent'] = [ $inner_content ];

		return serialize_block( $data );

	}

	/**
	 * Create the items html from the items array.
	 *
	 * @param  array $attrs Content array.
	 *
	 * @return string
	 */
	public static function create_items( array $attrs ): string {

		$rtn = '';

		if ( empty( $attrs ) ) {
			return $rtn;
		}

		// Create the main title and paragraph.
		$rtn .= CoreHeading::create(
			$attrs['title'] ?? '',
			[
				'level' => 2,
				'attrs' => [ 'className' => self::CENTER_CLASS ],
			]
		);
		$rtn .= CoreParagraph::create( $attrs['paragraph'] ?? '', [ 'attrs' => [ 'className' => self::CENTER_CLASS ] ] );

		$columns = [];

		foreach ( $attrs['columns'] as $column ) {

			$title     = CoreHeading::create(
				$column['title'] ?? '',
				[
					'level' => 3,
					'attrs' => [
						'className' => self::CENTER_CLASS,
						'textAlign' => 'center',
					],
				]
			);
			$paragraph = CoreParagraph::create(
				$column['paragraph'] ?? '',
				[
					'attrs' => [
						'className' => self::CENTER_CLASS,
						'align'     => 'center',
					],
				]
			);

			$columns[] = CoreColumn::create(
				$title . $paragraph,
				[
					'attrs' => [
						'className'         => 'wp-block-column is-vertically-aligned-center',
						'verticalAlignment' => 'center',
					],
				]
			);

		}

		$rtn .= CoreColumns::create(
			implode( PHP_EOL, $columns ),
			[
				'attrs' => [
					'className'         => 'wp-block-columns are-vertically-aligned-center',
					'verticalAlignment' => 'center',
				],
			]
		);

		return $rtn;

	}

}
