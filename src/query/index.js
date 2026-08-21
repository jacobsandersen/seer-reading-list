/**
 * Registers the Seer Book Query block.
 */
import { registerBlockType } from '@wordpress/blocks';
import { InnerBlocks } from '@wordpress/block-editor';
import './style.scss';
import Edit from './edit';
import metadata from './block.json';

registerBlockType( metadata.name, {
	edit: Edit,
	/**
	 * Persist the arranged inner item blocks so they can be rendered per book
	 * on the front end. The visual output is server-rendered.
	 */
	save: () => <InnerBlocks.Content />,
} );
