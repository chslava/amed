var
    gulp  = require('gulp'),
    watch = require('./ui/tasks/watch'),
    build = require('./ui/tasks/build'),
    pug = require('gulp-pug'),
    browserSyncConfig = require('./package.json')['browsersync'],
    browserSync = require('browser-sync').create()
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

    gulp.src('./dist/js/**/*.*')
        .pipe(gulp.dest('./wp-content/themes/amedical/js/'));
});

gulp.task('build-ui', ['semantic-build', 'pug-build','copytotheme']);
gulp.task('develop', ['semantic-watch', 'pug-watch']);

gulp.task('browser-sync', function () {
    browserSync.init(browserSyncConfig);
    gulp.watch(["dist/*.html", 'dist/ui/*.css']).on('change', browserSync.reload);
});

