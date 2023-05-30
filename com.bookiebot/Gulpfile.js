

var del = require('del');
var gulp = require('gulp');
var $ = require('gulp-load-plugins')();
var EXT = "js";
var ENV = "production";


gulp.task('js:build', function() {
    return gulp.src('./public/_media/js/Betstock/**/*.' + EXT.trim())
        .pipe($.concat('bundle.js'))
        .pipe($.size())
        .pipe($.rename({suffix: '.min'}))
        //.pipe($.uglify())
        .pipe(gulp.dest('./public/_media/js/compiled/Betstock'));
});


// watch task
gulp.task('js:watch', ['js:build'], function() {
    gulp.watch('./public/_media/js/Betstock/**/*.' + EXT.trim(), ['js:build']);
});

// default task
gulp.task('js', ['js:watch']);