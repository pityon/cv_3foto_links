const gulp = require('gulp');
const { taskSassWatch } = require('./_gulp/task-sass');

// -----------   IMPORT   -----------------------------

require('./_gulp/task-sass');

// -----------   END IMPORT   -----------------------------

// run as: `gulp watch` or `npm run watch`
gulp.task('watch', gulp.parallel([
    taskSassWatch
]));

// run as: `gulp`
gulp.task('default', gulp.parallel(['watch']));
