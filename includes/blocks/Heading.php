<?php

namespace PhpBlockBuilders\Blocks;

use UK_CONTENT_PUBLISH_MIGRATION_PLUGIN\Modules\Set\Base;

/**
 * Class Heading
 *
 * @package PhpBlockBuilders\Blocks
 */
class Heading extends Base implements BlockInterface {

	/**
	 * Return a Gutenberg heading block
	 *
	 * @param  array  $attrs
	 *
	 * @return string
	 */
	public static function create( array $attrs ): string {

		$classname = isset( $attrs['classname'] ) ? "{$attrs['classname']} content" : 'content';
		$inner_content = (string) $this->get_markdown_converter()->convert( $this->custom_string_transforms( $attrs['content'] ) );
		$inner_content = str_replace( [ '<p>', '</p>' ], [
			"<h{$attrs['level']}>",
			"</h{$attrs['level']}>",
		], $inner_content );
		$inner_content = trim( str_replace( "<h{$attrs['level']}>", "<h{$attrs['level']} class=\"{$classname}\">", $inner_content ) );

		$data = [
			'blockName'    => 'core/heading',
			'innerContent' => [ $inner_content ],
			'attrs'        => [
				'className' => $attrs['classname'],
				'level'     => absint( $attrs['level'] ),
			],
		];

		return serialize_block( $data );
	}

}
