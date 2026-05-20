const { registerBlockType } = wp.blocks;
const { InspectorControls } = wp.blockEditor;
const { PanelBody, SelectControl } = wp.components;
const { Fragment, createElement } = wp.element;
const ServerSideRender = wp.serverSideRender;

registerBlockType("up-instagram/up-instagram-block", {
    title: "UP Instagram",
    icon: "instagram",
    category: "common",
    attributes: {
        selectedAccount: {
            type: "string",
            default: "",
        },
    },
    edit: (props) => {
        const { attributes, setAttributes } = props;
        const { selectedAccount } = attributes;

        // Use the options passed from PHP.
        const accountOptions = window.up_instagram_account_options || [
            { label: "Select an account", value: "" }
        ];

        return createElement(
            Fragment,
            null,
            // Inspector controls in the sidebar.
            createElement(
                InspectorControls,
                null,
                createElement(
                    PanelBody,
                    { title: "Account Selection" },
                    createElement(SelectControl, {
                        label: "Choose an account",
                        value: selectedAccount,
                        options: accountOptions,
                        onChange: (value) => setAttributes({ selectedAccount: value })
                    })
                )
            ),
            // Display the PHP-rendered output in the editor.
            createElement(ServerSideRender, {
                block: "up-instagram/up-instagram-block",
                attributes: attributes,
            })
        );
    },
    save: () => null, // Frontend rendering handled via PHP.
});
