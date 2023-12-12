import gulp from 'gulp';
import yargs from 'yargs';
import dartSass from 'sass';
import gulpSass from 'gulp-sass';
import CleanCSS from 'gulp-clean-css';
import gulpIf from 'gulp-if';
import sourcemaps from 'gulp-sourcemaps';
import imagemin from 'gulp-imagemin';
import del from 'del';
import webpack from 'webpack-stream';
import uglify from 'gulp-uglify';
import named from 'vinyl-named';
import zip from 'gulp-zip';
import replace from 'gulp-replace';
import info from './package.json';

const sass = gulpSass(dartSass);

const paths = {
    styles: {
        src: ['src/assets/scss/bundle.scss', 'src/assets/scss/admin.scss'],
        dest: 'dist/assets/css'
    },
    images: {
        src: 'src/assets/images/**/*.{jpg,jpeg,png,svg,gif}',
        dest: 'dist/assets/images'
    },
    scripts: {
        src: ['src/assets/js/bundle.js', 'src/assets/js/admin.js'],
        dest: 'dist/assets/js'
    },
    other: {
        src: ['src/assets/**/*', '!src/assets/{images,js,scss}', '!src/assets/{images,js,scss}/**/*'],
        dest: 'dist/assets'
    },
    packaged: {
        src: ['**/*', '!.vscode', '!node_modules{,/**}', '!packaged{,/**}', '!src{,/**}', '!.babelrc', '!.gitignore', '!gulpfile.babel.js', '!package-lock.json', '!package.json'],
        dest: 'packaged'
    }
}

const PRODUCTION = yargs.argv.prod;

export const clean = () => del(['dist']);

export const styles = () => {
    return gulp.src(paths.styles.src)
        .pipe(gulpIf(!PRODUCTION, sourcemaps.init()))
        .pipe(sass().on('error', sass.logError))
        .pipe(gulpIf(PRODUCTION, CleanCSS({compatibility: 'ie8' })))
        .pipe(gulpIf(!PRODUCTION, sourcemaps.write()))
        .pipe(gulp.dest(paths.styles.dest));
}

export const images = () => {
    return gulp.src(paths.images.src)
        .pipe(gulpIf(PRODUCTION, imagemin()))
        .pipe(gulp.dest(paths.images.dest))
}

export const copy = () => {
    return gulp.src(paths.other.src)
        .pipe(gulp.dest(paths.other.dest))
}

export const scripts = () => {
    return gulp.src(paths.scripts.src)
        .pipe(named())
        .pipe(webpack({
            module: {
                loaders: [
                    {
                        test: /\.js$/,
                        use: {
                            loader: 'babel-loader',
                            options: {
                                presets: [ "@babel/preset-env" ]
                            }
                        }
                    }
                ]
            },
            output: {
                filename: '[name].js'
            },
            devtool: !PRODUCTION ? 'inline-source-map' : false
        }))
        .pipe(gulpIf(PRODUCTION, uglify()))
        .pipe(gulp.dest(paths.scripts.dest))
}

export const compress = () => {
    return gulp.src(paths.packaged.src)
        .pipe(replace('_themename', info.name))
        .pipe(zip(`${info.name}.zip`))
        .pipe(gulp.dest(paths.packaged.dest));
}


export const watch = () => {
    gulp.watch('src/assets/**/*.scss', styles);
    gulp.watch('src/assets/**/*.js', scripts);
    gulp.watch(paths.images.src, images);
    gulp.watch(paths.other.src, copy);
}

export const dev = gulp.series(clean, gulp.parallel(styles, scripts, images, copy), watch);
export const build = gulp.series(clean, gulp.parallel(styles, scripts, images, copy));
export const bundle = gulp.series(build, compress);

export default dev;