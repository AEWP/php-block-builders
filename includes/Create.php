<?php
/**
 * Class Create
 *
 * @package PhpBlockBuilders
 */

namespace PhpBlockBuilders;

use PhpBlockBuilders\Enum\OutputEnum;

/**
 * Class Create
 *
 * @package PhpBlockBuilders
 */
class Create {

	use Helper\OutputTrait;

	/**
	 * The Block Object.
	 *
	 * @var Block
	 */
	public Block $block;


	/**
	 * Output array or string.
	 *
	 * @var array|string
	 */
	public array|string $output; // phpcs:ignore


	/**
	 * Return a string representation of each block.
	 *
	 * @param string $block_name The block name (core/paragraph).
	 * @param array  $attrs Block attributes.
	 * @param string $inner_html Inner Html string.
	 * @param array  $inner_content Inner content array (should replicate inner html).
	 * @param string $output_format Output render format.
	 *
	 * @return void The Gutenberg-compatible output.
	 */
	public function __construct(
		string $block_name = '',
		array $attrs = [],
		string $inner_html = '',
		array $inner_content = [],
		string $output_format = 'render'
	) {

		$this->block = new Block(
			block_name: $block_name,
			attrs: $attrs,
			inner_html: $inner_html,
			inner_content: $inner_content
		);

		$output = match ( strtolower( $output_format ) ) {
			'render' => OutputEnum::RENDER,
			'serialize' => OutputEnum::SERIALIZE,
			'template' => OutputEnum::TEMPLATE,
			default => null
		};

		if ( ! $output ) {
			return;
		}







	}
}
