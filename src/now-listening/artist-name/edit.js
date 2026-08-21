/**
 * Editor view for the Seer Artist Name block.
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
				<PanelBody title={ __( 'Artist Name Settings', 'seer' ) }>
					<RangeControl
						label={ __( 'Artist name size', 'seer' ) }
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
					className: 'seer-now-listening__artist',
					style: { '--srl-size': `${ size }px` },
				} ) }
			>
				Sample Artist
			</span>
		</>
	);
}
