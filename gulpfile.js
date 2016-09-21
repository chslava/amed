var
    gulp  = require('gulp'),
    browserSyncConfig = require('./package.json')['browsersync'],
    browserSync = require('browser-sync').create(),
    watch = require('./ui/tasks/watch'),
    build = require('./ui/tasks/build'),
    pug = require('gulp-pug')

;

function swallowError (error) {

    // If you want details of the error in the console
    console.log(error.toString())

    this.emit('end')
}

// watch & build Semantic UI
gulp.task('semantic-watch', watch);
gulp.task('semantic-build', build);

// watch & build Pug
gulp.task('pug-watch', function () {
    gulp.watch('views/**/*.pug', ['pug-build'])
});

gulp.task('pug-build', function buildHTML() {
    return gulp.src('views/*.pug')
        .pipe(pug({
           pretty: true
        })).on('error', swallowError).pipe(gulp.dest('./dist'))
});

gulp.task('copytotheme', function() {
    gulp.src('./dist/ui/**/*.{css,js,eot,svg,ttf,woff,woff2}')
        .pipe(gulp.dest('./wp-content/themes/amedical/ui/'));

    gulp.src('./dist/css/**/*.*')
        .pipe(gulp.dest('./wp-content/themes/amedical/css/'));

    gulp.src('./dist/fonts/**/*.*')
        .pipe(gulp.dest('./wp-content/themes/amedical/fonts/'));

    gulp.src('./dist/js/**/*.*')
        .pipe(gulp.dest('./wp-content/themes/amedical/js/'));


    gulp.src('./dist/fonts/**/*.*')
        .pipe(gulp.dest('./wp-content/themes/amedical/ui/fonts/'));
});

gulp.task('build-ui', ['semantic-build', 'pug-build','copytotheme']);
gulp.task('develop', ['semantic-watch', 'pug-watch']);


gulp.task('simple-build-css', ['build-css'], function() {
    return gulp.src('./dist/ui/**/*.css')
        .pipe(browserSync.stream());
});

gulp.task('browser-sync', function () {
    browserSync.init(browserSyncConfig);
    gulp.watch("./ui/src/themes/amedical/**/*.{overrides,variables,less}", ['simple-build-css']);
    gulp.watch('views/**/*.pug', ['pug-build']);
    gulp.watch(["dist/*.html"]).on('change', browserSync.reload);
});

