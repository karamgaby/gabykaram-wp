/**
 * Configuration for Gulp. Based largely on Sage by Roots.
 */
const {enabled, path} = require('../config');
const {updateTimestamp} = require('../helpers/update-timeStamp');
/**
 * Site config
 */
const manifest = require('./../../assets/manifest.js');
/**
 * Global modules
 */
const concat = require('gulp-concat');
const gulpif = require('gulp-if');
const lazypipe = require('lazypipe');
const sourcemaps = require('gulp-sourcemaps');
const uglify = require('gulp-uglify');
const babel = require('gulp-babel');

/**
 * Process: JS
 *
 * Sourcemap, combine, minimize.
 *
 * gulp.src(jsFiles)
 *   .pipe(jsTasks('main.js')
 *   .pipe(gulp.dest(path.base.dist + 'scripts'))
 * ```
 */
const jsTasks = (filename) => {
  updateTimestamp('js');
  return lazypipe()
    // init sourcemaps
    .pipe(function () {
      return gulpif(enabled.maps, sourcemaps.init());
    })

    // transpile
    .pipe(function () {
      return babel({
        presets: ["@babel/preset-env", "@babel/preset-react"],
        overrides: [{
          test: manifest.babelIgnores(),
          sourceType: "script",
        }],
      });
    })

    // combine files
    .pipe(concat, filename)
    // minify
    .pipe(uglify, {
      compress: {
        'drop_debugger': enabled.stripJSDebug
      }
    })
    // build sourcemaps
    .pipe(function () {
      return gulpif(enabled.maps, sourcemaps.write('.', {
        sourceRoot: path.scripts.source
      }));
    })();
};

module.exports = {
  jsTasks
}
