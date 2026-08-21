/**
 * Editor view for the Seer Song Name block.
 *
 * Static sample only; real data renders server-side on the front end.
 */
import { __ } from '@wordpress/i18n';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, RangeControl, ToggleControl } from '@wordpress/components';

/**
 * @param {Object} props            Edit props.
 * @param {Object} props.attributes Block attributes.
 * @return {Element} Element to render.
 */
export default function Edit( props ) {
	const { attributes, setAttributes } = props;
	const { size, linkToLastFm } = attributes;

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Song Name Settings', 'seer' ) }>
					<RangeControl
						label={ __( 'Song name size', 'seer' ) }
						value={ size }
						min={ 12 }
						max={ 48 }
						onChange={ ( value ) =>
							setAttributes( { size: Number( value ) } )
						}
					/>
					<ToggleControl
						label={ __( 'Link to Last.fm', 'seer' ) }
						help={ __(
							'Makes the song name a link to its Last.fm page.',
							'seer'
						) }
						checked={ linkToLastFm }
						onChange={ ( value ) =>
							setAttributes( { linkToLastFm: value } )
						}
					/>
				</PanelBody>
			</InspectorControls>
			<span
				{ ...useBlockProps( {
					className: 'seer-now-listening__song',
					style: { '--srl-size': `${ size }px` },
				} ) }
			>
				Sample Song
			</span>
		</>
	);
}
