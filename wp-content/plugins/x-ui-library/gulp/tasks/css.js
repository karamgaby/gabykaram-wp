const lazypipe = require("lazypipe");
const gulpif = require("gulp-if");
const {enabled, path} = require("../config");
const plumber = require("gulp-plumber");
const sourcemaps = require("gulp-sourcemaps");
const autoprefixer = require("gulp-autoprefixer");
const concat = require("gulp-concat");
const cleancss = require("gulp-clean-css");
const sass = require('gulp-sass')(require('sass'));
// @todo recheck - redo code review
/**
 * Process: CSS
 *
 * SASS, autoprefix, sourcemap styles.
 *
 * gulp.src(cssFiles)
 *   .pipe(cssTasks('main.css')
 *   .pipe(gulp.dest(path.base.dist + 'styles'))
 */
const cssTasks = (filename) => {
  return lazypipe()
    // catch syntax errors (don't break pipe)
    .pipe(function() {
      return gulpif(!enabled.failStyleTask, plumber());
    })
    // init sourcemaps
    .pipe(function() {
      return gulpif(enabled.maps, sourcemaps.init());
    })
    // sass
    .pipe(function() {
      return gulpif('*.scss', sass({
        outputStyle: 'expanded',// compressed // lib doesn't support expanded yet
        precision: 8,
        includePaths: ['.'],
        errLogToConsole: !enabled.failStyleTask
      }));
    })
    // autoprefix
    .pipe(autoprefixer, {
      "grid": "no-autoplace"
    })
    // combine files
    .pipe(concat, filename)
    // minify
    .pipe(cleancss, {})
    // build sourcemaps
    .pipe(function() {
      return gulpif(enabled.maps, sourcemaps.write('.', {
        sourceRoot: path.styles.source
      }));
    })();
};

module.exports = {
  cssTasks
}
