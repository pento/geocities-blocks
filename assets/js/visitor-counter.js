/**
 * External dependencies
 */
import { padStart } from 'lodash';

/**
 * WordPress dependencies
 */
import { __, _n, sprintf } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { PanelBody, RangeControl, SVG } from '@wordpress/components';
import { InspectorControls } from '@wordpress/editor';
import { Fragment } from '@wordpress/element';

/**
 * Internal dependencies
 */
import '../css/visitor-counter.scss';

registerBlockType( 'geocities/visitor-counter', {
	title: __( 'Counter', 'geocities-blocks' ),

	description: __( 'Display the number of visitors to your site.', 'geocities-blocks' ),

	icon: <SVG xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" d="M0 0h24v24H0V0z" /><path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6h-6z" /></SVG>,

	category: 'geocities',

	attributes: {
		count: {
			type: 'number',
			source: 'meta',
			meta: 'geocities-blocks-visitor-count',
			default: 0,
		},
		padding: {
			type: 'number',
			default: 8,
		},
	},

	edit( { attributes, className, setAttributes } ) {
		const { count, padding } = attributes;

		const alt = _n(
			'There has been %d visitor to this page.',
			'There have been %d visitors to this page.',
			count,
			'geocities-blocks'
		);

		const countString = padStart( count, padding, '0' );

		const backgroundString = '8'.repeat( countString.length );

		return (
			<Fragment>
				<InspectorControls>
					<PanelBody title={ __( 'Counter Settings', 'geocities-blocks' ) }>
						<RangeControl
							label={ __( 'Padding Digits' ) }
							value={ padding }
							onChange={ ( nextPadding ) => {
								setAttributes( {
									padding: nextPadding,
								} );
							} }
							min={ 0 }
							max={ 20 }
							help={ __( 'If the visitor count is less than this number of digits, it will be padded with zeros to this length.', 'geocities-blocks' ) }
						/>
					</PanelBody>
				</InspectorControls>
				<div className={ `${ className }` } key="block">
					<div className="screen-reader-text">
						{ sprintf( alt, count ) }
					</div>
					<div aria-hidden={ true }>
						<div className="visitor-counter-border visitor-counter-top-border"></div>
						<div className="visitor-counter-border visitor-counter-right-border"></div>
						<div className="visitor-counter-border visitor-counter-bottom-border"></div>
						<div className="visitor-counter-border visitor-counter-left-border"></div>
						<div className="visitor-counter-background-digits">{ backgroundString }</div>
						<div className="visitor-counter-digits">{ countString }</div>
					</div>
				</div>
			</Fragment>
		);
	},

	save() {
		return null;
	},
} );
