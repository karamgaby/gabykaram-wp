/**
 * wp.domReady is a promise that resolves when the Gutenberg DOM is ready.
* */
wp.domReady(function () {
    disableUnwantedRichTextBlocks();
    handleGutenbergRequiredAttributes();
    disableUnwantedCoreContainerOptions();
    
})

function disableUnwantedRichTextBlocks() {
    wp.richText.unregisterFormatType('core/image');
    wp.richText.unregisterFormatType('core/text-color');
    wp.richText.unregisterFormatType('core/keyboard');
    wp.richText.unregisterFormatType('core/code');
}
function handleGutenbergRequiredAttributes() {
    const locks = [];
    
    wp.data.subscribe( () => {
        const postTitle = wp.data.select( 'core/editor' ).getEditedPostAttribute( 'title' );
        lock(
            ! postTitle,
            'title-lock',
            'Please enter a title',
        );
    } );
    
    function lock( lockIt, handle, message ) {
        if ( lockIt ) {
            if ( ! locks[ handle ] ) {
                locks[ handle ] = true;
                wp.data.dispatch( 'core/editor' ).lockPostSaving( handle );
                wp.data.dispatch( 'core/notices' ).createNotice(
                    'error',
                    message,
                    { id: handle, isDismissible: false }
                );
            }
        } else if ( locks[ handle ] ) {
            locks[ handle ] = false;
            wp.data.dispatch( 'core/editor' ).unlockPostSaving( handle );
            wp.data.dispatch( 'core/notices' ).removeNotice( handle );
        }
    }
}
function disableUnwantedCoreContainerOptions() {
    const library_group = wp.element.createElement(wp.primitives.SVG, {
        viewBox: "0 0 24 24",
        xmlns: "http://www.w3.org/2000/svg"
    }, wp.element.createElement(wp.primitives.Path, {
        d: "M18 4h-7c-1.1 0-2 .9-2 2v3H6c-1.1 0-2 .9-2 2v7c0 1.1.9 2 2 2h7c1.1 0 2-.9 2-2v-3h3c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-4.5 14c0 .3-.2.5-.5.5H6c-.3 0-.5-.2-.5-.5v-7c0-.3.2-.5.5-.5h3V13c0 1.1.9 2 2 2h2.5v3zm0-4.5H11c-.3 0-.5-.2-.5-.5v-2.5H13c.3 0 .5.2.5.5v2.5zm5-.5c0 .3-.2.5-.5.5h-3V11c0-1.1-.9-2-2-2h-2.5V6c0-.3.2-.5.5-.5h7c.3 0 .5.2.5.5v7z"
    }))
    wp.hooks.addFilter(
        "blocks.registerBlockType",
        "pluginname/group",
        (settings, name) => {
            if (name !== "core/group") {
                return settings;
            }

            return {
                ...settings,
                supports: {
                    ...settings.supports,
                    __experimentalLayout: false,
                },
                variations: [{
                    name: 'group',
                    title: wp.i18n.__('Group'),
                    description: wp.i18n.__('Gather blocks in a container.'),
                    attributes: {
                        layout: {
                            type: 'constrained'
                        }
                    },
                    isDefault: true,
                    scope: ['inserter', 'transform'],
                    isActive: blockAttributes => {
                        var _blockAttributes$layo, _blockAttributes$layo2, _blockAttributes$layo3;
            
                        return !blockAttributes.layout || !((_blockAttributes$layo = blockAttributes.layout) !== null && _blockAttributes$layo !== void 0 && _blockAttributes$layo.type) || ((_blockAttributes$layo2 = blockAttributes.layout) === null || _blockAttributes$layo2 === void 0 ? void 0 : _blockAttributes$layo2.type) === 'default' || ((_blockAttributes$layo3 = blockAttributes.layout) === null || _blockAttributes$layo3 === void 0 ? void 0 : _blockAttributes$layo3.type) === 'constrained';
                    },
                    icon: library_group
                }],
            };
        },
        20
    );
}
(function ($) {
    lazyload();
    
    function lazyload() {
        $('.lazy').lazy({
            effect: "fadeIn",
            effectTime: 500,
            threshold: 0
        });
        
        setInterval(function () {
            $(document).find("img.lazy").Lazy({chainable: false}).update([0])
        }, 1200)
    }
    
})(jQuery);

