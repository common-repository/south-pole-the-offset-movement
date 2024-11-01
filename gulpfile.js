
var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var cssmin = require('gulp-cssmin');
var rename = require('gulp-rename');

var plumber = require('gulp-plumber');
// Sass to CSS task
// autoprefixer latest 2 versions
gulp.task('styles', function() {
  return gulp.src('./css/sass/co2ok.scss')
    .pipe(plumber({
      errorHandler: function (err) {
          console.log(err);
          this.emit('end');
      }
    }))
    .pipe(sass())
    .pipe(gulp.dest('./css/'))
    .pipe(cssmin())
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(autoprefixer({
            browsers: ['last 4 versions'],
            cascade: false
    }))
    .pipe(gulp.dest('./css/'))
});

gulp.task('default', ['styles'], function () {

    gulp.watch('./css/sass/**/*.scss', ['styles']);
    // gulp.watch('./prototype/**/*.html', ['html']);
});
