const gulp = require("gulp");
const {jsonToSass, jsonToPhp} = require("gulp-json-data-to-sass");
const merge = require("merge-stream");

function toPascalCase(str) {
  // replace underscores and hyphens with spaces, then uppercase each word and remove spaces
  return str.replace(/(^\w|-\w|_\w)/g, (match) => match[0] === '-' || match[0] === '_' ? match[1].toUpperCase() : match.toUpperCase());
}

const tokensTasks = () => {
  const files = [
    {
      file: 'grid',
      isGroup: true,
    },
    {
      file: 'typographies',
      isGroup: false,
    },
    {
      file: 'colors',
      isGroup: false,
    },

  ];

  const tasks = files.map(file => {
    const src = gulp.src(`assets/0.tokens/${file.file}.json`);
    const commonOptions = {

    };

    const scssTransform = src.pipe(jsonToSass({
      sass: `assets/styles/src/1.design-system/0.tokens/_${file.file}.scss`,
      isGroup: file.isGroup,
      prefix: file.isGroup ? `x_${file.file}`: 'x',
      suffix: '',
      separator: '_',
      ...commonOptions
    }));


    const phpTransform = src.pipe(jsonToPhp({
      php: `inc/Core/Tokens/${toPascalCase(file.file)}.php`,
      namespace: 'X_UI\\Core\\Tokens',
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
