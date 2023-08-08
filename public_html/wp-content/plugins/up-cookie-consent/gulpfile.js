const 	gulp = require('gulp');
// const 	webpack = require('webpack');
// const 	watch = require('gulp-watch');
const 	sass = require('gulp-sass')(require('sass'));
const 	concat = require('gulp-concat');
const 	sourcemaps = require('gulp-sourcemaps');
const 	autoprefixer = require('gulp-autoprefixer');
const 	rename = require('gulp-rename');
// const 	jslint = require('gulp-jslint');
const 	uglify = require('gulp-uglify');
const 	browserSync = require('browser-sync').create();
const	sassGlob = require('gulp-sass-glob');
// const 	gulpIgnore = require('gulp-ignore');

const 	urlToPreview = 'http://localhost/';
// const	lintOptions = {
// 						"white": true,
// 						"this": true, 
// 						"long": true,
// 						"fudge": true,
// 						"esversion": 6,
// 						"unused": false,
// 						"unparam": true
// 					}


// function to complie Front sass
function compileFront() {
	return gulp
		.src('./sass/up-cookie-consent-public.scss')
		.pipe(sassGlob())
		.pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
		.pipe(browserSync.stream())
		.pipe(autoprefixer({overrideBrowserslist: ['last 2 versions', '> 5%']}))
		.pipe(gulp.dest('./public/css/'))
}

// function to complie Admin sass
function compileAdmin() {
	return gulp
		.src('./sass/up-cookie-consent-admin.scss')
		.pipe(sassGlob())
		.pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
		.pipe(browserSync.stream())
		.pipe(autoprefixer({overrideBrowserslist: ['last 2 versions', '> 5%']}))
		.pipe(gulp.dest('./admin/css/'))
}



// compile everything at once
function compileAll() {
	compileAdmin();
	compileFront();
}

gulp.task('sass', async function() {
	compileAdmin();
	compileFront();
});

gulp.task('compile', async function() {
    compileAll();
});

gulp.task('watch', function () {
	browserSync.init({
		notify: false,
		proxy: urlToPreview,
		ghostMode: false
	});
	gulp.watch('./**/*.php', function (done) {
		console.log('php');
		browserSync.reload();
		done();
	});
	gulp.watch('./sass/*.scss', function (done) {
		console.log('main scss');
		compileAdmin();
		compileFront();
		//  no browserSync required here
		done();
	});

});