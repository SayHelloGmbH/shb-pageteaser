import { SelectControl, Spinner } from "@wordpress/components";
import { useSelect, withSelect } from "@wordpress/data";
import { Component, Fragment } from "@wordpress/element";
import { __ } from "@wordpress/i18n";

class PostSelector extends Component {
    constructor(props) {
        super(...arguments);
        this.props = props;
    }

    setPost(post) {
        const { setAttributes } = this.props;
        setAttributes({ post });
    }

    render() {
        const { attributes, selectOptions, label } = this.props;
        const { post } = attributes;

        return (
            <Fragment>
                {!selectOptions && <Spinner />}
                {!!selectOptions && (
                    <SelectControl
                        label={label}
                        value={post}
                        options={selectOptions}
                        onChange={this.setPost.bind(this)}
                    />
                )}
            </Fragment>
        );
    }
}

export default withSelect((select, props) => {
    const posts = useSelect(select => {
        return select("core").getEntityRecords("postType", props.post_type);
    });

    if (!posts) {
        return posts;
    }

    let selectOptions = [
        {
            label: __("No selection", "shb-pageteaser"),
            value: "",
        },
    ];

    posts.map(post => {
        selectOptions.push({ value: post.id, label: post.title.raw });
    });

    return {
        selectOptions: selectOptions,
    };
})(PostSelector);
