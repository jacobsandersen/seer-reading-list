/**
 * Editor view for the Seer Now Listening block.
 *
 * Shows a static sample track built from the arranged inner blocks. No
 * requests are made from the editor.
 */
import { __ } from '@wordpress/i18n';
import {
	InnerBlocks,
	InspectorControls,
	useBlockProps,
} from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';
import './editor.scss';

const ALLOWED_BLOCKS = [
	'core/group',
	'core/columns',
	'seer/now-listening-song-name',
	'seer/now-listening-artist-name',
	'seer/now-listening-album-art',
];

const TEMPLATE = [
	[ 'seer/now-listening-song-name' ],
	[ 'seer/now-listening-artist-name' ],
	[ 'seer/now-listening-album-art' ],
];

/**
 * @param {Object} props            Edit props.
 * @param {Object} props.attributes Block attributes.
 * @return {Element} Element to render.
 */
export default function Edit( props ) {
	const { attributes, setAttributes } = props;
	const { fallbackText } = attributes;

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Now Listening Settings', 'seer' ) }>
					<TextControl
						label={ __( 'Fallback text', 'seer' ) }
						help={ __(
							'Shown when Seer reports nothing playing.',
							'seer'
						) }
						value={ fallbackText }
						onChange={ ( value ) =>
							setAttributes( { fallbackText: value } )
						}
					/>
				</PanelBody>
			</InspectorControls>
			<div { ...useBlockProps() }>
				<div className="seer-now-listening__sample">
					<InnerBlocks
						allowedBlocks={ ALLOWED_BLOCKS }
						template={ TEMPLATE }
						orientation="vertical"
					/>
				</div>
			</div>
		</>
	);
}
