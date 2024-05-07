/**
 * Configuration for Gulp. Based largely on Sage by Roots.
 */
/**
 * Global modules
 */
const argv = require('minimist')(process.argv.slice(2));
/**
 * Asset paths
 */
const path = {
  "base": {
    "source": "assets/",
    "dist": "dist/",
  },
  "tokens": {
    "source": "assets/0.tokens/",
    "dist": "assets/styles/src/1.design-system/0.tokens/",
  },
  "scripts": {
    "source": "assets/scripts/",
    "dist": "dist/scripts/",
  },
  "styles": {
    "source": "assets/styles/",
    "dist": "dist/styles/",
  },
  "images": {
    "source": "assets/images/",
    "dist": "dist/images/",
  },
  "sprite": {
    "source": "assets/sprite/",
    "pluginSource": "../../plugins/x-ui-library/assets/sprite/",
    "dist": "dist/sprite/",
  },
  "modules": {
    "source": "modules/",
    "pluginModulesPath": "../../plugins/x-ui-library/modules/",
  }
};

/**
 * Disable or enable features
 */
const enabled = {
  // disable source maps when `--production`
  maps: !argv.production,
  // fail styles task on error when `--production`
  failStyleTask: argv.production,
  // fail due to JSHint warnings only when `--production`
  failJSHint: argv.production,
  // strip debug statments from javascript when `--production`
  stripJSDebug: argv.production
};

module.exports = {
  path,
  enabled
}
