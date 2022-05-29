const gulp = require('gulp'),
    sass = require('gulp-dart-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    debug = require('gulp-debug'),
    sourcemaps = require('gulp-sourcemaps');

const CSS_DIR = './views/css/';

const taskSass = () => {
    return gulp.src(`${CSS_DIR}**/*.scss`)
        .pipe(sourcemaps.init())
        .pipe(sass({
            outputStyle: 'expanded',
        }).on('error', sass.logError))
        .pipe(autoprefixer())
        .pipe(sourcemaps.write(''))
        .pipe(gulp.dest(CSS_DIR))
        .pipe(debug({title: 'output'}))
        ;
};
const taskSassWatch = () => {
    return gulp.watch(`${CSS_DIR}**/*.scss`, gulp.parallel(taskSass));
};

exports.taskSassWatch = taskSassWatch;
