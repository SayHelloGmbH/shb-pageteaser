import { __ } from "@wordpress/i18n";
import { InspectorControls, useBlockProps } from "@wordpress/block-editor";
import { PanelBody, SelectControl } from "@wordpress/components";
import { withSelect } from "@wordpress/data";
import { Fragment } from "@wordpress/element";
import ServerSideRender from "@wordpress/server-side-render";

import PostSelector from "./post-selector";

const Edit = props => {
    const { attributes, imageSizes, setAttributes } = props;
    const { imageSize } = attributes;

    return (
        <Fragment>
            <InspectorControls>
                <PanelBody label='x'>
                    <PostSelector
                        post_type='page'
                        attributes={attributes}
                        setAttributes={setAttributes}
                        label={__("Select page", "shb-pageteaser")}
                    />
                    <SelectControl
                        label={__("Image size", "shb-pageteaser")}
                        value={imageSize}
                        options={imageSizes}
                        onChange={imageSize => setAttributes({ imageSize })}
                    />
                </PanelBody>
            </InspectorControls>
            <div {...useBlockProps()}>
                <ServerSideRender block='shb/pageteaser' attributes={attributes} />
            </div>
        </Fragment>
    );
};

export default withSelect(select => {
    const settings = select("core/block-editor").getSettings(),
        imageSizes = [];

    settings.imageSizes.map(size => {
        imageSizes.push({ value: size.slug, label: size.name });
    });

    return {
        imageSizes,
    };
})(Edit);
