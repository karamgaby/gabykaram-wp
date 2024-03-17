const timestamps = require("../../assets/last-edited.json");
const file = require("gulp-file");
const gulp = require("gulp");

/**
 * Timestamps
 *
 * Update asset class timestamp to last-edited.json
 */
const updateTimestamp = (stamp) => {
  timestamps[stamp] = Date.now();
  return file(
    'last-edited.json',
    JSON.stringify(timestamps, null, 2),
    {src: true}
  )
    .pipe(gulp.dest('./assets'));
};

module.exports = {
  updateTimestamp
}
