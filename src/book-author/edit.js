/**
 * Editor view for the Seer Book Author block.
 *
 * Shows a static sample author. No requests are made from the editor.
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
				<PanelBody
					title={ __( 'Author Settings', 'seer-reading-list' ) }
				>
					<RangeControl
						label={ __( 'Author size', 'seer-reading-list' ) }
						value={ size }
						min={ 10 }
						max={ 32 }
						onChange={ ( value ) =>
							setAttributes( { size: Number( value ) } )
						}
					/>
				</PanelBody>
			</InspectorControls>
			<span
				{ ...useBlockProps( {
					className: 'seer-reading-list__author',
					style: { '--srl-size': `${ size }px` },
				} ) }
			>
				{ __( 'Sample Author', 'seer-reading-list' ) }
			</span>
		</>
	);
}
