/**
 * Editor view for the Seer Album Art block.
 *
 * Static sample only; real data renders server-side on the front end.
 */
import { __ } from '@wordpress/i18n';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, RangeControl, SelectControl } from '@wordpress/components';

const IMAGE_SIZES = [
	{ label: 'Small (34px)', value: 'small' },
	{ label: 'Medium (64px)', value: 'medium' },
	{ label: 'Large (174px)', value: 'large' },
	{ label: 'Extra large (300px)', value: 'extralarge' },
];

/**
 * @param {Object} props            Edit props.
 * @param {Object} props.attributes Block attributes.
 * @return {Element} Element to render.
 */
export default function Edit( props ) {
	const { attributes, setAttributes } = props;
	const { imageSize, imageWidth } = attributes;

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Album Art Settings', 'seer' ) }>
					<SelectControl
						label={ __( 'Artwork source size', 'seer' ) }
						value={ imageSize }
						options={ IMAGE_SIZES }
						onChange={ ( value ) =>
							setAttributes( { imageSize: value } )
						}
					/>
					<RangeControl
						label={ __( 'Display width', 'seer' ) }
						value={ imageWidth }
						min={ 40 }
						max={ 400 }
						step={ 10 }
						onChange={ ( value ) =>
							setAttributes( { imageWidth: Number( value ) } )
						}
					/>
				</PanelBody>
			</InspectorControls>
			<div
				{ ...useBlockProps( {
					className: 'seer-now-listening__art',
					style: {
						'--srl-image-width': `${ imageWidth }px`,
					},
				} ) }
			>
				<span className="seer-now-listening__art-placeholder" />
			</div>
		</>
	);
}
