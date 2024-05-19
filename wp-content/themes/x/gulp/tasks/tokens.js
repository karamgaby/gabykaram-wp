const gulp = require("gulp");
const {jsonToSass, jsonToPhp} = require("gulp-json-data-to-sass");
const merge = require("merge-stream");
const {getModuleJsons} = require("../helpers/modules");
const {path} = require('../config');

const tokensTasks = () => {
  const files = [];
  const modulesJson = getModuleJsons();

  for (const module of modulesJson) {
    if (module.json.tokens && module.json.tokens.path) {
      const fileConfig = {
        file: module.name,
        className: 'Tokens',
        isGroup: !!module.json.isGroup,
        path: `${path.modules.source}${module.name}/assets/0.tokens/${module.json.tokens.path}`,
      }
      if (module.json.tokens.scssOutput) {
        fileConfig.scssOutput = `${path.modules.source}${module.name}/assets/styles/0.tokens/_${module.name}.scss`;
      }
      if (module.json.tokens.phpOutput) {
        fileConfig.phpOutput = `${path.modules.source}${module.name}/${module.json.tokens.phpOutput}`;
        fileConfig.namespace = module.json.tokens.namespace;
      }
      files.push(fileConfig)
    }
  }

  const tasks = files.map(file => {
    const src = gulp.src(file.path);
    const commonOptions = {};

    let scssTransform = null;
    if (file.scssOutput) {
      scssTransform = src.pipe(jsonToSass({
        sass: file.scssOutput,
        isGroup: !!file.isGroup,
        prefix: file.isGroup ? `x_${file.file}` : 'x',
        suffix: '',
        separator: '_',
        ...commonOptions
      }));

    }
    let phpTransform = null;
    if (file.phpOutput) {
      phpTransform = src.pipe(jsonToPhp({
        php: file.phpOutput,
        className: file.className,
        namespace: file.namespace,
        abstractClassUse: 'X_UI\\Core\\AbstractTokens',
        abstractClass: 'AbstractTokens',
        ...commonOptions
      }));
    }
    if (phpTransform && scssTransform) {
      return merge(scssTransform, phpTransform);
    } else if (phpTransform) {
      return phpTransform;
    }
    return scssTransform;
  });

  return merge(tasks);
}

module.exports = {
  tokensTasks
}
