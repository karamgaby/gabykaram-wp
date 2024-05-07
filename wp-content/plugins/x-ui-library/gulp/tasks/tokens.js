const gulp = require("gulp");
const {jsonToSass, jsonToPhp} = require("gulp-json-data-to-sass");
const merge = require("merge-stream");
const {getModuleJsons} = require("../helpers/modules");
const { path} = require('../config');

const tokensTasks = () => {
  const files = [
    {
      file: 'grid',
      className: 'Grid',
      isGroup: true,
      path: 'assets/0.tokens/grid.json',
      scssOutput: 'assets/styles/src/1.design-system/0.tokens/_grid.scss',
      phpOutput: `inc/Core/Tokens/Grid.php`,
      namespace: 'X_UI\\Core\\Tokens',

    },
    {
      file: 'typographies',
      className: 'Typographies',
      isGroup: false,
      path: 'assets/0.tokens/typographies.json',
      scssOutput: 'assets/styles/src/1.design-system/0.tokens/_typographies.scss',
      phpOutput: `inc/Core/Tokens/Typographies.php`,
      namespace: 'X_UI\\Core\\Tokens',

    },
    {
      file: 'colors',
      className: 'Colors',
      isGroup: false,
      path: 'assets/0.tokens/colors.json',
      scssOutput: 'assets/styles/src/1.design-system/0.tokens/_colors.scss',
      phpOutput: `inc/Core/Tokens/Colors.php`,
      namespace: 'X_UI\\Core\\Tokens',

    },

  ];
  const modulesJson = getModuleJsons();

  for (const module of modulesJson) {
    console.log('module', module);
    if(module.json.tokens && module.json.tokens.path) {
      files.push({
        file: module.name,
        className: 'Tokens',
        isGroup: !!module.json.isGroup,
        path: `${path.modules.source}${module.name}/assets/0.tokens/${module.json.tokens.path}`,
        scssOutput: `${path.modules.source}${module.name}/assets/styles/0.tokens/_${module.name}.scss`,
        phpOutput: `${path.modules.source}${module.name}/${module.json.tokens.phpOutput}`,
        namespace: module.json.tokens.namespace
      })
    }
  }
  console.log('files', files);

  const tasks = files.map(file => {
    const src = gulp.src(file.path);
    const commonOptions = {};

    const scssTransform = src.pipe(jsonToSass({
      sass: file.scssOutput,
      isGroup: !!file.isGroup,
      prefix: file.isGroup ? `x_${file.file}` : 'x',
      suffix: '',
      separator: '_',
      ...commonOptions
    }));

    const phpTransform = src.pipe(jsonToPhp({
      php: file.phpOutput,
      className: file.className,
      namespace: file.namespace,
      abstractClassUse: 'X_UI\\Core\\AbstractTokens',
      abstractClass: 'AbstractTokens',
      ...commonOptions
    }));
    return merge(scssTransform, phpTransform);
  });

  return merge(tasks);
}

module.exports = {
  tokensTasks
}
