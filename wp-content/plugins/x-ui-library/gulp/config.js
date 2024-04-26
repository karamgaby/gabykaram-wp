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
// @todo tokens props extend to have a dist for php and a dist for scss
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
  "modules": {
    "source": "modules/",
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
