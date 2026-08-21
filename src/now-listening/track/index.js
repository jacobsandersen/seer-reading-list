/**
 * Registers the Seer Now Listening block.
 */
import { registerBlockType } from '@wordpress/blocks';
import { InnerBlocks } from '@wordpress/block-editor';
import './style.scss';
import Edit from './edit';
import metadata from './block.json';

registerBlockType( metadata.name, {
	edit: Edit,
	/**
	 * Persist the arranged inner item blocks so they can be rendered with the
	 * current track on the front end. Visual output is server-rendered.
	 */
	save: () => <InnerBlocks.Content />,
} );
