<?php
/**
 * Block Interface
 *
 * @package PhpBlockBuilders\Blocks
 */

namespace PhpBlockBuilders;

/**
 * Block creator interface
 */
interface BlockInterface {

	/**
	 * All blocks must at least create a block
	 *
	 * @param  string  $content Any text or html content
	 * @param  array  $attrs  Block attributes.
	 *
	 * @return string
	 */
	public static function create( string $content = '', array $attrs = [] ) :string;
}
