/**
 * Project specific gulp configuration
 */

module.exports = {

  /**
   * URL for BrowserSync to mirror
   */
  devUrl: () => "http://gabykaram.local/",

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
        'node_modules/bootstrap/dist/js/bootstrap.bundle.js',
        // Module files
        "../../plugins/x-ui-library/modules/buttons/assets/scripts/cf7.js",
        // Themes Modules
        "modules/inputs/assets/scripts/inputs-cf7.js",
        // IE11 polyfill for external x:link svg (https://github.com/Keyamoon/svgxuse)
        // "node_modules/svgxuse/svgxuse.js",

        // IE11 polyfill for forEach
        // "node_modules/nodelist-foreach-polyfill/index.js",

        // IE 11 ponyfill for css vars
        "node_modules/css-vars-ponyfill/dist/css-vars-ponyfill.min.js",

        // vanilla js version of fitvids, that makes iframe videos responsice (https://www.npmjs.com/package/fitvids)
        "node_modules/fitvids/dist/fitvids.min.js",
        "node_modules/@fancyapps/ui/dist/fancybox/fancybox.umd.js",

        // project specific js
        // "assets/scripts/lib/in-viewport.js",
        "assets/scripts/lib/blocks.js",
        "assets/scripts/lib/swiper.min.js",
        "modules/MenuBar/assets/scripts/menu.js",
        "assets/scripts/main.js"

      ],

      // gutenberg editor specific js
      "editor-gutenberg.js": [

        "assets/scripts/editor-gutenberg.js"

      ]

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
      "node_modules/@fancyapps/ui/dist/fancybox/fancybox.umd.js",
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
