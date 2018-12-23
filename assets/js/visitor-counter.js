/**
 * External dependencies
 */
import { padStart } from 'lodash';

/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';

/**
 * Internal dependencies
 */
import '../css/visitor-counter.scss';

registerBlockType( 'geocities/visitor-counter', {
	title: __( 'Counter' ),

	description: __( 'Display the number of visitors to your site.', 'geocities-blocks' ),

	icon: <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" d="M0 0h24v24H0V0z" /><path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6h-6z" /></svg>,

	category: 'geocities',

	attributes: {
		count: {
			type: 'number',
			source: 'meta',
			meta: 'geocities-blocks-visitor-count',
			default: 0,
		},
	},

	edit( { attributes, className } ) {
		const { count } = attributes;

		return (
			<div className={ `${ className }` } key="block">
				<div className="visitor-counter-border visitor-counter-top-border"></div>
				<div className="visitor-counter-border visitor-counter-right-border"></div>
				<div className="visitor-counter-border visitor-counter-bottom-border"></div>
				<div className="visitor-counter-border visitor-counter-left-border"></div>
				<div className="visitor-counter-digits">
					{ padStart( count, 8, '0' ) }
				</div>
			</div>
		);
	},

	save() {
		return null;
	},
} );
