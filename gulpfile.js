'use strict';
var gulp         = require('gulp'),
    concat       = require('gulp-concat'),
    uglify       = require('gulp-uglify'),
    less         = require('gulp-less'),
    cleanCss     = require('gulp-clean-css'),
    del          = require('del'),
    sourcemaps   = require('gulp-sourcemaps'),
    babel        = require('gulp-babel');

gulp.task('clean', function () {
    del(['less', 'js', 'images', 'fonts']);
});

gulp.task('less', function() {
    return gulp.src([
        'web-src/less/main.less'
    ])
        .pipe(sourcemaps.init(''))
        .pipe(less())
        .pipe(cleanCss())
        .pipe(sourcemaps.write('./maps'))
        .pipe(gulp.dest('web/css/'));
});

gulp.task('js', function() {
    return gulp.src([
        'bower_components/jquery/dist/jquery.js',
        'bower_components/bootstrap/dist/js/bootstrap.js'
    ])
        .pipe(sourcemaps.init())
        .pipe(babel({compact: true}))
        .pipe(concat('app.js'))
        .pipe(uglify())
        .pipe(sourcemaps.write("./maps"))
        .pipe(gulp.dest('web/js'));
});

gulp.task('pages-js', function() {
    return gulp.src([
        'web-src/js/*.js',
        'web-src/js/**/*.js'
    ])
        .pipe(sourcemaps.init())
        .pipe(babel({compact: true}))
        .pipe(uglify())
        .pipe(sourcemaps.write("./maps"))
        .pipe(gulp.dest('web/js'));
});

gulp.task('fonts', function () {
    return gulp.src(['bower_components/bootstrap/fonts/*'])
        .pipe(gulp.dest('web/fonts/'))
});

gulp.task('img', function () {
    return gulp.src(['web-src/img/**/*'])
        .pipe(gulp.dest('web/img/'))
});

gulp.task('default', ['clean'], function () {
    var tasks = [
        'fonts',
        'img',
        'less',
        'js'
    ];

    tasks.forEach(function (val) {
        gulp.start(val);
    });
});

gulp.task('watch', ['less', 'pages-js'], function () {
    gulp.watch('web-src/less/*.less', ['less']);
    gulp.watch('web-src/less/**/*.less', ['less']);
    gulp.watch('web-src/js/*.js', ['pages-js']);
    gulp.watch('web-src/js/**/*.js', ['pages-js']);
});