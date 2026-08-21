/**
 * Editor view for the Seer Book Title block.
 *
 * Shows a static sample title. No requests are made from the editor.
 */
import { __ } from '@wordpress/i18n';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, RangeControl } from '@wordpress/components';

/**
 * @param {Object} props            Edit props.
 * @param {Object} props.attributes Block attributes.
 * @return {Element} Element to render.
 */
export default function Edit( props ) {
	const { attributes, setAttributes } = props;
	const { size } = attributes;

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Title Settings', 'seer' ) }>
					<RangeControl
						label={ __( 'Title size', 'seer' ) }
						value={ size }
						min={ 12 }
						max={ 48 }
						onChange={ ( value ) =>
							setAttributes( { size: Number( value ) } )
						}
					/>
				</PanelBody>
			</InspectorControls>
			<span
				{ ...useBlockProps( {
					className: 'seer-reading-list__title',
					style: { '--srl-size': `${ size }px` },
				} ) }
			>
				{ __( 'Sample Book', 'seer' ) }
			</span>
		</>
	);
}
