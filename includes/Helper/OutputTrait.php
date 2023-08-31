<?php
/**
 * Trait OutputTrait
 *
 * @package PhpBlockBuilders\Helper
 */

namespace PhpBlockBuilders\Helper;

use PhpBlockBuilders\Enum\OutputEnum;

/**
 * Trait OutputTrait
 *
 * @package PhpBlockBuilders\Helper
 */
trait OutputTrait {


	public function get_output(OutputEnum $output): array|string {
		return call_user_func([$this, $output->value], []);
	}





	/**
	 * Render a block for front end.
	 *
	 *
	 * @return string
	 */
	private function render(array $data): string {
		return \render_block( $data );
	}


	/**
	 * Return block HTML with attributes as comments for use in editor.
	 *
	 * @param array $data Block data.
	 *
	 * @return string
	 */
	private function serialize( array $data ): string {
		return serialize_block( $data );
	}

	/**
	 * Return the block data as an array ready to use in register_post_type templates.
	 *
	 * @param array $data Block data.
	 *
	 * @return array
	 */
	private function template( array $data ): array {

		return $data;
	}
}
