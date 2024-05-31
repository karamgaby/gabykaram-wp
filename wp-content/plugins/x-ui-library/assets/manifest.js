/**
 * Project specific gulp configuration
 */

module.exports = {

  /**
   * URL for BrowserSync to mirror
   */
  devUrl: () => "http://playgroundplayhouse.local",

  /**
   * JS files
   *
   * "build-file-name.js": [
   *   "../node_modules/some-module/some-module.js",
   *   "scripts/cool-scripts.js"
   * ]
   */
  js: () => {
    return {

      // main js to be loaded in footer
      "main.js": [

        // Modules specific js
        "modules/buttons/assets/scripts/cf7.js",
        // IE 11 ponyfill for css vars
        "node_modules/css-vars-ponyfill/dist/css-vars-ponyfill.min.js",

        // project specific js
        "assets/scripts/main.js"

      ],
    }
  },

  /**
   * Babel ignores
   *
   * Babel messes up scripts that use "this" and these need to be skipped
   *
   * @see https://stackoverflow.com/a/34983495
   */
  babelIgnores: () => {
    return [
      "./node_modules/@rqrauhvmra/tobi/js/tobi.js",
      "./node_modules/axios/dist/axios.min.js",
      "./modules/lightbox/assets/vendor/tobi/js/tobi.js",
      "./modules/lightbox/assets/vendor/tobi/js/tobi.min.js"
    ];
  },

  /**
   * CSS files
   *
   * "build-file-name.css": [
   *   "../node_modules/some-module/some-module.css",
   *   "styles/main.scss"
   * ]
   */
  css: () => {
    return {

      "utils.css": [
        "assets/styles/utils.scss"
      ],

      "main.css": [
        "assets/styles/main.scss"
      ],

      "editor-gutenberg.css": [
        "assets/styles/editor-gutenberg.scss"
      ],

      "editor-classic.css": [
        "assets/styles/editor-classic.scss"
      ],

      "admin.css": [
        "assets/styles/admin.scss"
      ]

    }
  },

  tokens: () => {
    return [
      'assets/tokens/grid.json',
      'assets/tokens/colors.json',
      'assets/tokens/typographies.json',
    ];
  }

};
