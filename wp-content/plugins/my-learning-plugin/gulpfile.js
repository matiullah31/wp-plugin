// Load Gulp...of course
var gulp         = require( 'gulp' );

// CSS related plugins
var sass         = require( 'gulp-sass' );
var autoprefixer = require( 'gulp-autoprefixer' );
var minifycss    = require( 'gulp-uglifycss' );

// JS related plugins
var concat       = require( 'gulp-concat' );
var uglify       = require( 'gulp-uglify' );
var babelify     = require( 'babelify' );
var browserify   = require( 'browserify' );
var source       = require( 'vinyl-source-stream' );
var buffer       = require( 'vinyl-buffer' );
var stripDebug   = require( 'gulp-strip-debug' );

// Utility plugins
var rename       = require( 'gulp-rename' );
var sourcemaps   = require( 'gulp-sourcemaps' );
var notify       = require( 'gulp-notify' );
var plumber      = require( 'gulp-plumber' );
var options      = require( 'gulp-options' );
var gulpif       = require( 'gulp-if' );

// Browers related plugins
var browserSync  = require( 'browser-sync' ).create();
var reload       = browserSync.reload;

// Project related variables

var styleSRC     = './src/scss/mystyle.scss';
var styleURL     = './assets/';
var mapURL       = './';

var jsSRC        = './src/js/myscript.js';
var jsURL        = './assets/';

var styleWatch   = './src/scss/**/*.scss';
var jsWatch      = './src/js/**/*.js';
var phpWatch     = './**/*.php';

// Tasks
function browser_sync(done) {
	browserSync.init({
		server:{
			baseDir: './src/'
		}
	});
	done();
}

function css(done) {
	gulp.src( styleSRC )
		.pipe( sourcemaps.init() )
		.pipe( sass({
			errLogToConsole: true,
			outputStyle: 'compressed'
		}) )
		.on( 'error', console.error.bind( console ) )
		.pipe( autoprefixer({ browsers: [ 'last 2 versions', '> 5%', 'Firefox ESR' ] }) )
		.pipe( sourcemaps.write( mapURL ) )
		.pipe( gulp.dest( styleURL ) )
		.pipe( browserSync.stream() );

		done();
}

function js(done) {
	return browserify({
		entries: [jsSRC]
	})
	.transform( babelify, { presets: [ '@babel/preset-env' ] } )
	.bundle()
	.pipe( source( 'myscript.js' ) )
	.pipe( buffer() )
	.pipe( gulpif( options.has( 'production' ), stripDebug() ) )
	.pipe( sourcemaps.init({ loadMaps: true }) )
	.pipe( uglify() )
	.pipe( sourcemaps.write( '.' ) )
	//.pipe( rename({extname: ".min.js"}) )
	.pipe( gulp.dest( jsURL ) )
	.pipe( browserSync.stream() );

	done();
 }

function triggerPlumber( src, url ) {
	return gulp.src( src )
	.pipe( plumber() )
	.pipe( gulp.dest( url ) );
}

function watch_assets(done){
	gulp.watch( phpWatch, reload );
	gulp.watch( styleWatch, css );
	gulp.watch( jsWatch, gulp.series(js,reload) );
	//gulp.src( jsURL + 'myscript.min.js' )
	gulp.src( jsURL + 'myscript.js' )
	.pipe( notify({ message: 'Gulp is Watching, Happy Coding!' }) );
	
	done();
}

function completed(done) {
	//gulp.src( jsURL + 'myscript.min.js' )
	gulp.src( jsURL + 'myscript.js' )
		.pipe( notify({ message: 'Assets Compiled!' }) );
	done();
 }

gulp.task('css',css);
gulp.task('js',js);
gulp.task('watch_assets',watch_assets);
gulp.task('browser_sync',browser_sync);
gulp.task('completed',completed);
gulp.task('watch', gulp.series(watch_assets,browser_sync));
gulp.task('default',gulp.series(css,js,completed));
