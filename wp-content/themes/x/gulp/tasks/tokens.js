const gulp = require("gulp");
const jsonToSass = require("gulp-json-data-to-sass");
const merge = require("merge-stream");
const {path} = require("../config");

const tokensTasks = () => {
  const merged = merge();
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
    return gulp.src(`assets/0.tokens/${file.file}.json`)
      .pipe(jsonToSass({
        sass: `assets/styles/src/1.design-system/0.tokens/_${file.file}.scss`,
        prefix: file.isGroup ? `x_${file.file}`: 'x',
        suffix: '',
        separator: '_',
        isGroup: file.isGroup,
      }));
  });
  return merge(tasks);
}

module.exports = {
  tokensTasks
}
