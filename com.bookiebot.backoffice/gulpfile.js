

var del = require('del');
var gulp = require('gulp');
var $ = require('gulp-load-plugins')();
var EXT = "js";
var ENV = "pdoruction";


//Build Files After Watch
gulp.task('js:build', function() {
    return gulp.src('./CMS/_media/APP/**/*.' + EXT.trim())
        .pipe($.concat('bundle.js'))
        .pipe($.plumber())
        .pipe($.rename({suffix: '.min'}))
        .pipe($.plumber.stop())
        .pipe(gulp.dest('./CMS/_media/compiled'));
});


// watch task
gulp.task('js:watch', ['js:build'], function() {
    gulp.watch('./CMS/_media/APP/**/*.' + EXT.trim(), ['js:build']);
});


// default task
gulp.task('js', ['js:watch']);