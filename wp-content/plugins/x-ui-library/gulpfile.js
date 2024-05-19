/**
 * Configuration for Gulp. Based largely on Sage by Roots.
 */
const {enabled, path} = require('./gulp/config');
const {updateTimestamp} = require('./gulp/helpers/update-timeStamp');
const {getModuleJsons} = require("./gulp/helpers/modules");

const {cssTasks} = require('./gulp/tasks/css');
const {jsTasks} = require('./gulp/tasks/js');
const {tokensTasks} = require('./gulp/tasks/tokens');
/**
 * Site config
 */
// @todo now just have been reviewed for json generation
const manifest = require('./assets/manifest.js');
/**
 * Global modules
 */
const argv = require('minimist')(process.argv.slice(2));
const browsersync = require('browser-sync').create();
const gulp = require('gulp');
const del = require('del');
const gulpif = require('gulp-if');
const jshint = require('gulp-jshint');
const merge = require('merge-stream');

const getAssets = () => {
  let manifest_json = {
    'js': manifest.js(),
    'css': manifest.css(),
  }

  getModuleJsons().forEach(module => {
    if (module.json.css) {
      Object.entries(module.json.css).forEach(([target, sources]) => {
        if (typeof sources !== 'undefined' && sources.length > 0) {
          sources.forEach(source => {
            manifest_json.css[target].push('modules/' + module.name + '/' + source);
          });
        }
      });
    }
    if (module.json.js) {
      Object.entries(module.json.js).forEach(([target, sources]) => {
        if (typeof sources !== 'undefined' && sources.length > 0) {
          sources.forEach(source => {
            manifest_json.js[target].push('modules/' + module.name + '/' + source);
          });
        }
      });
    }
  });

  return manifest_json;
}

/**
 * Build variable for assets
 *
 * Create array with information of assets:
 * {
 *   'name': main.css,
 *   'globs': 'assets/main.scss,assets/print.scss'
 * }
 */
var buildAssets = (buildFiles) => {
  let result = [];
  for (let buildFile in buildFiles) {
    // set correct asset paths
    /*for (i = 0; i < buildFiles[buildFile].length; i++) {
      buildFiles[buildFile][i] = path.base.source + buildFiles[buildFile][i];
    }*/
    result.push({
      'name': buildFile,
      'globs': buildFiles[buildFile],
    });
  }
  return result;
};
var jsAssets = buildAssets(getAssets().js);
var cssAssets = buildAssets(getAssets().css);


/**
 * Task: Tokens
 * */
gulp.task('buildJsonToken', () => {
  return tokensTasks();
});

/**
 * Task: Styles
 *
 * `gulp styles` - Compiles, combines, and optimizes Bower CSS and project CSS.
 * By default this task will only log a warning if a precompiler error is
 * raised. If the `--production` flag is set: this task will fail outright.
 */
gulp.task('styles', () => {
  const merged = merge();
  cssAssets = buildAssets(getAssets().css);

  // update last-edited.json
  updateTimestamp('css');
  // process all assets
  for (i = 0; i < cssAssets.length; i++) {
    let asset = cssAssets[i];
    const cssTasksInstance = cssTasks(asset.name);
    // handle possible errors
    if (!enabled.failStyleTask) {
      cssTasksInstance.on('error', function (err) {
        console.error(err.message);
        this.emit('end');
      });
    }

    // merge
    merged.add(
      gulp.src(asset.globs, {base: 'styles'})
        .pipe(cssTasksInstance)
    );
  }
  return merged
    .on('error', function (err) {
      console.log(err.message);
    })
    .pipe(gulp.dest(path.styles.dist))
    .pipe(gulpif(!argv.q, browsersync.stream({match: '**/*.css'})))
});

/**
 * Task: Scripts
 *
 * `gulp scripts` - Runs JSHint then compiles, combines, and optimizes JS.
 */
gulp.task('scripts', () => {
  const merged = merge();
  jsAssets = buildAssets(getAssets().js);

  // process all assets
  for (i = 0; i < jsAssets.length; i++) {
    let asset = jsAssets[i];
    const jsTasksInstance = jsTasks(asset.name);
    //merge
    merged.add(
      gulp.src(asset.globs, {base: 'scripts'})
        .pipe(jsTasksInstance)
    );
  }
  return merged
    .on('error', function (err) {
      console.log(err.message);
    })
    .pipe(gulp.dest(path.scripts.dist))
    .pipe(gulpif(!argv.q, browsersync.stream({match: '**/*.js'})));
});


/**
 * Task: JSHint
 *
 * `gulp jshint` - Lints configuration JSON and project JS.
 */
gulp.task('jshint', () => {
  let allJS = [];
  for (let i = 0; i < jsAssets.length; i++) {
    let globsArray = jsAssets[i].globs;
    for (let j = 0; j < globsArray.length; j++) {
      allJS.push(globsArray[j]);
    }
  }
  return gulp.src([
    'gulpfile.js'
  ].concat(allJS))
    .pipe(jshint())
    .pipe(jshint.reporter('jshint-stylish'))
    .pipe(gulpif(enabled.failJSHint, jshint.reporter('fail')));
});

/**
 * Task: Clean
 *
 * `gulp clean` - Deletes the build folder entirely.
 */
gulp.task('clean', () => {
  return del(path.base.dist);
});

/**
 * Task: Watch
 *
 * `gulp watch` - Use BrowserSync to proxy your dev server and synchronize code
 * changes across devices. Specify the hostname of your dev server at
 * `manifest.devUrl`. When a modification is made to an asset, run the
 * build step for that asset and inject the changes into the page.
 * See: http://www.browsersync.io
 */
gulp.task('watch', () => {
  if (!argv.q) {
    // browsersync changes unless in quiet mode
    browsersync.init({
      files: [
        '{inc,blocks,modules}/**/*.php',
        '*.php'
      ],
      proxy: manifest.devUrl(),
      snippetOptions: {
        whitelist: ['/wp-admin/admin-ajax.php'],
        blacklist: ['/wp-admin/**']
      },
      open: 'local'
    });
  }

  // watch these files
  gulp.watch(path.styles.source + '**/*.scss', gulp.task('styles'));
  gulp.watch(path.scripts.source + '**/*.js', gulp.task('scripts'));
  gulp.watch(path.tokens.source + '*.json', gulp.task('buildJsonToken')).on(
    'change',
    () => {
      console.log('tokens change')
      // gulp.parallel('styles', 'scripts', 'jshint');
    }
  );
  // gulp.watch('./assets/*.json', buildJsonToken).on('change', buildCss);
  // modules
  gulp.watch(path.modules.source + '**/*.scss', gulp.task('styles'));
  gulp.watch(path.modules.source + '**/*.js', gulp.task('scripts'));
  gulp.watch(path.modules.source + '**/assets/0.tokens/*.json', gulp.task('buildJsonToken')).on(
    'change',
    () => {
      console.log('tokens change')
      // gulp.parallel('styles', 'scripts', 'jshint');
    }
  );

  gulp.watch([
    'gulpfile.js',
    'assets/manifest.js',
    'gulp/**/*',
    path.modules.source + '*/_.json'
  ], () => {
    console.log("\n⚠️  Configuration modified. Restart gulp. ⚠️\n");
    return process.exit();
  });

  gulp.watch([
      path.modules.source + '*',
    ],
    gulp.task('default')
  )
});

/**
 * Task: Build
 *
 * `gulp build` - Run all the build tasks but don't clean up beforehand.
 * Generally you should be running `gulp` instead of `gulp build`.
 */

gulp.task('build', gulp.series(
  gulp.parallel('buildJsonToken'),
  gulp.parallel('styles', 'scripts', 'jshint'),
));

/**
 * Task: Default
 *
 * `gulp` - Run a complete build. To compile for production run `gulp --production`.
 */
gulp.task('default', gulp.series('clean', 'build'));
