/**
 * Editor view for the Seer Last Read block.
 *
 * Static sample only; real data renders server-side on the front end.
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
					title={ __( 'Last Read Settings', 'seer-reading-list' ) }
				>
					<RangeControl
						label={ __( 'Size', 'seer-reading-list' ) }
						value={ size }
						min={ 10 }
						max={ 24 }
						onChange={ ( value ) =>
							setAttributes( { size: Number( value ) } )
						}
					/>
				</PanelBody>
			</InspectorControls>
			<span
				{ ...useBlockProps( {
					className: 'seer-reading-list__meta-line',
					style: { '--srl-size': `${ size }px` },
				} ) }
			>
				{ __( 'Last read Jul 29, 2026', 'seer-reading-list' ) }
			</span>
		</>
	);
}
