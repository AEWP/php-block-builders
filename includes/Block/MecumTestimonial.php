<?php
/**
 * Class MecumTestimonial
 *
 * @package PhpBlockBuilders\Block
 */

declare( strict_types=1 );

namespace PhpBlockBuilders\Block;

use PhpBlockBuilders\BlockBase;

/**
 * Class MecumTestimonial
 *
 * @package PhpBlockBuilders\Block
 */
class MecumTestimonial extends BlockBase {

	/**
	 * The block name.
	 *
	 * @var string
	 */
	public static string $block_name = 'mecum/testimonial';

	/**
	 * The block classname.
	 *
	 * @var string
	 */
	public static string $block_classname = 'wp-block-mecum-testimonial';

	/**
	 * Create a Mecum Banner Block
	 *
	 * @param  string $content  The banner content.
	 * @param  array  $attrs  Block attributes.
	 *
	 * @return string
	 */
	public static function create( string $content = '', array $attrs = [] ): string {

		$data = self::get_data( $attrs );

		$image = CoreImage::create(
			(string) $attrs['image_id'],
			[
				'attrs' => [
					'className' => 'wp-block-image is-style-rounded',
					'align'     => 'center',
				],
			]
		);

		$quote = CoreQuote::create(
			$content,
			[
				'cite'  => $attrs['cite'] ?? '',
				'attrs' => [
					'className' => 'wp-block-quote ihas-text-align-center',
					'align'     => 'center',
				],
			]
		);

		$block_template = <<<'TEMPLATE'
		<div class="%1$s">%2$s</div>
		TEMPLATE;

		$inner_content = sprintf(
			$block_template,
			\esc_attr( $data['attrs']['className'] ), // 1
			$image . $quote, // 2
		);

		$data['innerContent'] = [ $inner_content ];

		return serialize_block( $data );

	}

}
