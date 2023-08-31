<?php
/**
 * Class Block
 *
 * @package PhpBlockBuilders
 */

namespace PhpBlockBuilders;

/**
 * Class Block
 *
 * @package PhpBlockBuilders
 */
class Block {


	/**
	 * Create a block object.
	 *
	 * @param string $block_name The block name (core/paragraph).
	 * @param array  $attrs Block attributes.
	 * @param string $inner_html Inner Html string.
	 * @param array  $inner_content Inner content array (should replicate inner html).
	 */
	public function __construct(
		public string $block_name,
		public array $attrs,
		public string $inner_html,
		public array $inner_content
	) {}
}
