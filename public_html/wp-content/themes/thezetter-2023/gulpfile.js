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

// function to compile main sass
function compileSass() {
	return gulp
		.src(['./src/sass/**/*.scss', '!./src/sass/abovethefold.scss', '!./src/sass/secondary_styles.scss'])
		.pipe(sourcemaps.init())
		.pipe(sassGlob())
		.pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
		.pipe(browserSync.stream())
		.pipe(autoprefixer({overrideBrowserslist: ['last 2 versions', '> 5%']}))
		.pipe(sourcemaps.write('./'))
		.pipe(gulp.dest('./assets/css'))
}

// function to compile blocks sass
function compileBlocksSass() {
	return gulp
		.src(['./blocks/**/*.scss'])
		.pipe(sourcemaps.init())
		.pipe(sassGlob())
		.pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
		.pipe(browserSync.stream())
		.pipe(autoprefixer({overrideBrowserslist: ['last 2 versions', '> 5%']}))
		.pipe(sourcemaps.write('./'))
		.pipe(gulp.dest('./assets/css'))
}

// function to complie abovethefold sass
function compileAbovethefold() {
	return gulp
		.src(['./src/sass/abovethefold.scss', './src/sass/secondary_styles.scss'])
		.pipe(sassGlob())
		.pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
		.pipe(browserSync.stream())
		.pipe(autoprefixer({overrideBrowserslist: ['last 2 versions', '> 5%']}))
		.pipe(gulp.dest('./assets/css'))
}

// function to compile page builder js
function compileBlockScripts() {
	return gulp.src('./blocks/**/*.js')
		// .pipe(jslint(lintOptions))
		// .pipe(jslint.reporter( 'stylish' ))
		.pipe(uglify())
        .pipe(rename({suffix: '.min'}))
		.pipe(gulp.dest('./assets/js'));
}

// function to compile libs js
function compileLibScripts() {
	return gulp.src('./src/js/libs/*.js')
		.pipe(concat('libs.js'))
        .pipe(uglify())
        .pipe(rename({suffix: '.min'}))
		.pipe(gulp.dest('./assets/js'));
}

// function to compile main js
function compileMainScript() {
	return gulp.src('./src/js/main.js')
		// .pipe(jslint(lintOptions))
		// .pipe(jslint.reporter( 'stylish' ))
        .pipe(uglify())
        .pipe(rename({suffix: '.min'}))
		.pipe(gulp.dest('./assets/js'));
}

// function to compile gutenberg editor js
function compileGutenbergScript() {
	return gulp.src('./src/js/gutenberg.js')
		// .pipe(jslint(lintOptions))
		// .pipe(jslint.reporter( 'stylish' ))
		.pipe(gulp.dest('./assets/js'));
}

// compile everything at once
function compileAll() {
	compileSass();
	compileBlocksSass();
	compileAbovethefold();
    compileBlockScripts();
    compileLibScripts();
	compileMainScript();
	compileGutenbergScript();
}

gulp.task('sass', async function() {
	compileSass();
	compileBlocksSass();
	compileAbovethefold();
});

gulp.task('js', async function() {
    compileBlockScripts();
    compileLibScripts();
	compileMainScript();
	compileGutenbergScript();
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

	gulp.watch('./blocks/**/*.js', function (done) {
		console.log('blocks js');
	    compileBlockScripts();
		browserSync.reload();
		done();
	});

	gulp.watch('./src/js/libs/*.js', function (done) {
		console.log('lib js');
		compileLibScripts();
		browserSync.reload();
		done();
	});

	gulp.watch('./src/js/*.js', function (done) {
		console.log('main js');
		compileMainScript();
		compileGutenbergScript();
		browserSync.reload();
		done();
	});

	gulp.watch('./src/**/*.scss', function (done) {
		console.log('main scss');
		compileSass();
		compileBlocksSass();
		compileAbovethefold();
		//  no browserSync required here
		done();
	});

	gulp.watch('./blocks/**/*.scss', function (done) {
		console.log('blocks scss');
		compileSass();
		compileBlocksSass();
		compileAbovethefold();
		//  no browserSync required here
		done();
	});

});