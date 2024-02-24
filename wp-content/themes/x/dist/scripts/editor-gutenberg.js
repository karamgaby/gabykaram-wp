"use strict";wp.hooks.addFilter("editor.PostFeaturedImage.imageSize","x/featured-image-size",(e,s,o)=>"medium"),wp.hooks.addFilter("blocks.registerBlockType","x/blockFilters",(e,s)=>{return-1!==["core/html","core/shortcode","core/block","core/file"].indexOf(s)?e:lodash.assign({},e,{supports:lodash.assign({},e.supports,{className:!0})})});
//# sourceMappingURL=editor-gutenberg.js.map
