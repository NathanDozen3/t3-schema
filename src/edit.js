/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import {
    useBlockProps,
    ColorPalette,
    InspectorControls,
} from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';


/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

import { useState } from 'react';

import { PanelBody } from '@wordpress/components';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit( { attributes, setAttributes } ) {

	const [ button__background_color, setActiveColor ] = useState();

	return (
		<div { ...useBlockProps() }>
			<InspectorControls key="setting">
				<PanelBody
        			title = {__( 'Colors', 't3-schema' ) }
        			initialOpen = { true }
   				 >
					<fieldset>
						<legend className="blocks-base-control__label">
							{ __( 'Button Background Color', 't3-schema' ) }
						</legend>
						<ColorPalette
							value = { attributes.button__background_color }
							onChange = { ( color ) => {
								setActiveColor( color )
								setAttributes( { button__background_color:color } )
							}}
						/>
					</fieldset>
					<fieldset>
						<legend className="blocks-base-control__label">
							{ __( 'Active Button Background Color', 't3-schema' ) }
						</legend>
						<ColorPalette
							value = { attributes.button__background_color__active }
							onChange = { ( color ) => {
								setActiveColor( color )
								setAttributes( { button__background_color__active:color } )
							}}
						/>
					</fieldset>
					<fieldset>
						<legend className="blocks-base-control__label">
							{ __( 'Body Color', 't3-schema' ) }
						</legend>
						<ColorPalette
							value = { attributes.body__color }
							onChange = { ( color ) => {
								setActiveColor( color )
								setAttributes( { body__color:color } )
							}}
						/>
					</fieldset>
					<fieldset>
						<legend className="blocks-base-control__label">
							{ __( 'Body Background Color', 't3-schema' ) }
						</legend>
						<ColorPalette
							value = { attributes.body__background_color }
							onChange = { ( color ) => {
								setActiveColor( color )
								setAttributes( { body__background_color:color } )
							}}
						/>
					</fieldset>
				</PanelBody>
			</InspectorControls>
			<ServerSideRender
				block="t3/faq"
				attributes={ attributes }
			/>
		</div>
	);
}
