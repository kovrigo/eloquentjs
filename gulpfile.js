var gulp = require('gulp');
var phpspec = require('gulp-phpspec');
var phpunit = require('gulp-phpunit');
var paths = {
    specs: './spec/**/*.php',
    source: './src/**/*.php',
    tests: './tests/**/*.php'
};

gulp.task('test:spec', function () {
    gulp.src('phpspec.yml').pipe(phpspec());
});

gulp.task('watch:spec', function () {
    gulp.watch([paths.specs, paths.source], ['test:spec']);
});

gulp.task('test:unit', function () {
    gulp.src('phpunit.xml').pipe(phpunit()).on('error', error => console.log(error));
});

gulp.task('watch:unit', function () {
    gulp.watch([paths.tests, paths.source], ['test:unit']);
});

gulp.task('default', ['test:spec', 'test:unit', 'watch:spec', 'watch:unit']);
