var
    gulp  = require('gulp'),
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
    gulp.watch('views/*.pug', ['pug-build'])
});

gulp.task('pug-build', function buildHTML() {
    return gulp.src('views/*.pug')
        .pipe(pug({
           pretty: true
        })).on('error', swallowError).pipe(gulp.dest('./dist'))
});

gulp.task('build-ui', ['semantic-build', 'pug-build']);
gulp.task('develop', ['semantic-watch', 'pug-watch']);

