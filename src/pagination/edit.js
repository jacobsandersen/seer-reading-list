/**
 * Editor view for the Seer Pagination block.
 *
 * Static sample only; real pagination renders server-side on the front end.
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
					title={ __( 'Pagination Settings', 'seer-reading-list' ) }
				>
					<RangeControl
						label={ __( 'Size', 'seer-reading-list' ) }
						value={ size }
						min={ 10 }
						max={ 32 }
						onChange={ ( value ) =>
							setAttributes( { size: Number( value ) } )
						}
					/>
				</PanelBody>
			</InspectorControls>
			<div
				{ ...useBlockProps( {
					className: 'seer-reading-list__pagination',
					style: { '--srl-size': `${ size }px` },
				} ) }
			>
				<span className="seer-reading-list__prev" aria-disabled="true">
					{ __( 'Previous', 'seer-reading-list' ) }
				</span>
				<span className="seer-reading-list__page">
					{ __( 'Page 1 of 3', 'seer-reading-list' ) }
				</span>
				<span className="seer-reading-list__next">
					{ __( 'Next', 'seer-reading-list' ) }
				</span>
			</div>
		</>
	);
}
