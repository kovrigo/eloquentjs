var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var minifyCss = require('gulp-minify-css');

gulp.task('styles', () => {
    return gulp.src('_sass/site.scss')
        .pipe(sass())
        .pipe(autoprefixer())
        .pipe(minifyCss())
        .pipe(gulp.dest('assets/'));
});

gulp.task('styles:watch', () => {
    gulp.watch('_sass/**/*.scss', ['styles']);
});

gulp.task('default', ['styles', 'styles:watch']);