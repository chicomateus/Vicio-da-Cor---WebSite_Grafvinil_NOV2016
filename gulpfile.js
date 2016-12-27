  const gulp = require('gulp');
  runSequence = require('run-sequence');
	 browserSync = require('browser-sync').create();
   php  = require('gulp-connect-php');

// This will keeps pipes working after error event
 	 plumber = require('gulp-plumber');
	 notify = require("gulp-notify");

// Requires the gulp-sass plugin
 	sass = require('gulp-sass');
 	sassLint = require('gulp-sass-lint');
 	jshint = require("gulp-jshint");
  autoprefixer = require('gulp-autoprefixer');




/* ----------------------------TAREFAS - TASK's -------------------*/

// Run All tasks one by one
gulp.task('default',['browserSync']);

gulp.task('php', ['php-sync'], function () {
    gulp.watch(['app/*.php'], [reload]);
    gulp.watch('app/sass/**/*.scss', ['compile-sass']);
 	 gulp.watch('app/**/*.html', [reload]);
 	 gulp.watch(['app/css/**/*.css'], ['autoprefixerCSS', [reload]]);
 	 gulp.watch('app/js/**/*.js', ['JS-lint']);
});

// Run PHP server
gulp.task('php', function() {
    php.server({ base: 'app', port: 8010, keepalive: true});
});

/// ----------- Browser Sync  TASKS
gulp.task('browserSync', function() {
  browserSync.init({
    server: {
      baseDir: 'app'
    },
    https: false,

    // Stop the browser from automatically opening
	open: false,
	// Open the site in Chrome
	browser: "Chrome"
  })
})

gulp.task('php-sync',['php'], function() {
    browserSync({
        proxy: '127.0.0.1:8010',
        port: 8080,
        open: false,
        notify: true
    });
});

/* COMPILE SASS TASK
 - Verificação de erros no sass
 - Notificação dos erros encontrados
 - Compilação num ficheiro CSS
 - Browser Sync
*/
gulp.task('compile-sass', function () {
    return gulp.src('app/sass/**/*.scss') // path to your file
    .pipe(plumber({errorHandler: notify.onError("Error: <%= error.message %>")}))
    .pipe(sassLint())
    //.pipe(sassLint.format())
    .pipe(sassLint.failOnError())
    .pipe(sass({
      includePaths: require('node-normalize-scss').includePaths
    }))
    .pipe(gulp.dest('app/css/'))
    .pipe(notify({
      message: "Generated file: <%= file.relative %> @ <%= options.date %>",
      templateOptions: {
        date: new Date()
      }
    }))
    .pipe(browserSync.reload({stream: true}))
    .pipe(notify({
      message: "Browser updated @ <%= options.date %>",
      templateOptions: {
        date: new Date()
      }
    }))

});

// watch  SASS
gulp.task('watch-sass', function () {
   	 gulp.watch('app/sass/**/*.scss', ['compile-sass']);
});


/* JAVASCRIPT - Lint TASK
 - Verificação de erros no js
 - Notificação dos erros encontrados
 - Browser Sync
*/
gulp.task('JS-lint', function() {
	gulp.src(['app/js/**/*.js', '!app/js/vendor/**/*.js'])
    .pipe(jshint())
    // Use gulp-notify as jshint reporter
    .pipe(notify(function (file) {
      if (file.jshint.success) {
        // Don't show something if success

        return "JS file: <%= file.relative %> - Javascript sem erros"
      }

      var errors = file.jshint.results.map(function (data) {
        if (data.error) {
          return "(" + data.error.line + ':' + data.error.character + ') ' + data.error.reason;
        }
      }).join("\n");
      return file.relative + " (" + file.jshint.results.length + " errors)\n" + errors;
    }))
    // Update browser
    .pipe(browserSync.reload({stream: true}))
    .pipe(notify({
      message: "Browser updated @ <%= options.date %>",
      templateOptions: {
        date: new Date()
      }
    }))
});

//CSS autoprefixer
gulp.task('autoprefixerCSS', () =>
	gulp.src('app/css/**/*.css')
		.pipe(autoprefixer({
			browsers: ['last 2 versions']
		}))
    .pipe(gulp.dest('app/css/'))
);


// Other watchers
   // Reloads the browser whenever HTML or JS files change
   gulp.watch('app/sass/**/*.scss', ['compile-sass']);
	 gulp.watch('app/**/*.html', browserSync.reload);
	 gulp.watch('app/css/**/*.css', browserSync.reload);
	 gulp.watch('app/js/**/*.js', ['JS-lint']);
	 gulp.watch(['app/img/**/*'],browserSync.reload);




   /// DEPLOY TASKS
//-------------------- cleanDist
gulp.task('cleanDist', function () {
   var del = require('del');
   return del('dist')
  // notify({
  //    message: "Pasta 'Dist' Limpa!",
  //  });
});

   //-------------------- htmlDist
gulp.task('htmlDist', function () {
    return gulp.src('app/**/*.html')
    .pipe(gulp.dest('dist'))
    .pipe(notify({
      message: "HTML copiado para a pasta 'Dist'",
    }));

});
//-------------------- styleDist
gulp.task('styleDist', function () {
    return gulp.src('app/css/**/*.css')
    .pipe(gulp.dest('dist/css'))
    .pipe(notify({
      message: "STYLES copiado para a pasta 'Dist'",
    }));
});

//-------------------- scriptDist
gulp.task('scriptDist', function () {
    return gulp.src('app/js/**/*.js')
    .pipe(gulp.dest('dist/js'))
    .pipe(notify({
      message: "SCRIPTS copiado para a pasta 'Dist'",
    }));
});

//-------------------- imagesDist
gulp.task('imgDist', function () {
    return gulp.src('app/img/')
    .pipe(gulp.dest('dist/img'))
    .pipe(notify({
      message: "IMAGENS copiados para a pasta 'Dist'",
    }));
});
//-------------------- buildDist
gulp.task('buildDist', ['htmlDist', 'styleDist', 'scriptDist','imgDist']);

//-------------------- release
//gulp.task('release', ['cleanDist', 'buildDist']);
gulp.task('release', function(callback) {
  runSequence('cleanDist', 'buildDist', callback);
});
