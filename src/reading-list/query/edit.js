/**
 * Editor view for the Seer Book Query block.
 *
 * Shows a single sample book built from the arranged inner item blocks. No
 * requests are made from the editor.
 */
import { useEffect } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import {
	InnerBlocks,
	InspectorControls,
	useBlockProps,
} from '@wordpress/block-editor';
import { PanelBody, RangeControl, SelectControl } from '@wordpress/components';
import './editor.scss';

/**
 * Generate a stable unique id for pagination scoping.
 *
 * @return {string} A unique string.
 */
function generateId() {
	if ( typeof crypto !== 'undefined' && crypto.randomUUID ) {
		return crypto.randomUUID();
	}
	return Date.now().toString( 36 ) + Math.random().toString( 36 ).slice( 2 );
}

const COMPONENTS = [
	{ label: 'Previously Read', value: 'read' },
	{ label: 'Currently Reading', value: 'current' },
	{ label: 'Want to Read', value: 'wanted' },
];

const ALLOWED_BLOCKS = [
	'core/group',
	'core/columns',
	'seer/reading-list-book-cover',
	'seer/reading-list-book-title',
	'seer/reading-list-book-author',
	'seer/reading-list-book-meta-count',
	'seer/reading-list-book-meta-last-read',
	'seer/reading-list-pagination',
];

const TEMPLATE = [
	[ 'seer/reading-list-book-cover' ],
	[ 'seer/reading-list-book-title' ],
	[ 'seer/reading-list-book-author' ],
	[ 'seer/reading-list-book-meta-count' ],
	[ 'seer/reading-list-book-meta-last-read' ],
	[ 'seer/reading-list-pagination' ],
];

/**
 * @param {Object} props            Edit props.
 * @param {Object} props.attributes Block attributes.
 * @return {Element} Element to render.
 */
export default function Edit( props ) {
	const { attributes, setAttributes } = props;
	const { component, limit, columns, uid } = attributes;

	// Assign a stable per-block id used to scope pagination, so multiple query
	// blocks on a page paginate independently. Persists as a block attribute.
	useEffect( () => {
		if ( ! uid ) {
			setAttributes( { uid: generateId() } );
		}
	}, [ uid, setAttributes ] );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Seer Query Settings', 'seer' ) }>
					<SelectControl
						label={ __( 'Seer Component', 'seer' ) }
						value={ component }
						options={ COMPONENTS }
						onChange={ ( value ) =>
							setAttributes( { component: value } )
						}
					/>
					<RangeControl
						label={ __( 'Books to show', 'seer' ) }
						value={ limit }
						min={ 1 }
						max={ 50 }
						onChange={ ( value ) =>
							setAttributes( { limit: Number( value ) } )
						}
					/>
					<RangeControl
						label={ __( 'Columns', 'seer' ) }
						help={ __(
							'1 stacks books in a single column.',
							'seer'
						) }
						value={ columns }
						min={ 1 }
						max={ 8 }
						onChange={ ( value ) =>
							setAttributes( { columns: Number( value ) } )
						}
					/>
				</PanelBody>
			</InspectorControls>
			<div { ...useBlockProps() }>
				<div className="seer-reading-list__sample">
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
