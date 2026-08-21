/**
 * Editor view for the Seer Book Cover block.
 *
 * Shows a bordered placeholder sized to the configured image width. No
 * requests are made from the editor.
 */
import { __ } from '@wordpress/i18n';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, RangeControl } from '@wordpress/components';
import './editor.scss';

/**
 * @param {Object} props            Edit props.
 * @param {Object} props.attributes Block attributes.
 * @return {Element} Element to render.
 */
export default function Edit( props ) {
	const { attributes, setAttributes } = props;
	const { imageWidth } = attributes;

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Cover Settings', 'seer' ) }>
					<RangeControl
						label={ __( 'Image width', 'seer' ) }
						value={ imageWidth }
						min={ 60 }
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
					className: 'seer-reading-list__cover',
					style: { '--srl-image-width': `${ imageWidth }px` },
				} ) }
			>
				<span className="seer-reading-list__cover-placeholder" />
			</div>
		</>
	);
}
