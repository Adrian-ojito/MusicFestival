import path from 'path'
import fs from 'fs'
import { glob } from 'glob'
import { src, dest, watch, series, parallel } from 'gulp'
import * as dartSass from 'sass'
import gulpSass from 'gulp-sass'
import concat from 'gulp-concat'
import terser from 'gulp-terser'
import sharp from 'sharp'
import rename from 'gulp-rename'
import plumber from 'gulp-plumber'

const sass = gulpSass(dartSass)

const paths = {
    scss: 'src/scss/**/*.scss',
    js: 'src/js/**/*.js',
    img: 'src/img/**/*'
}

export function css() {
    return src(paths.scss, { sourcemaps: true })
        .pipe(plumber())
        .pipe(sass({ outputStyle: 'compressed' }).on('error', sass.logError))
        .pipe(dest('./build/css', { sourcemaps: '.' }))
}

export function js() {
    return src(paths.js)
        .pipe(plumber())
        .pipe(concat('bundle.js'))
        .pipe(terser())
        .pipe(rename({ suffix: '.min' }))
        .pipe(dest('./build/js'))
}

export async function imagenes() {
    const srcDir = './src/img'
    const buildDir = './build/img'
    const images = await glob(`${srcDir}/**/*`, { nodir: true })

    if (images.length === 0) return

    await Promise.all(images.map(file => procesarImagen(file, srcDir, buildDir)))
}

async function procesarImagen(file, srcDir, buildDir) {
    const relativePath = path.relative(srcDir, path.dirname(file))
    const outputSubDir = path.join(buildDir, relativePath)

    if (!fs.existsSync(outputSubDir)) {
        fs.mkdirSync(outputSubDir, { recursive: true })
    }

    const baseName = path.basename(file, path.extname(file))
    const extName = path.extname(file)

    if (extName.toLowerCase() === '.svg') {
        const outputFile = path.join(outputSubDir, `${baseName}${extName}`)
        fs.copyFileSync(file, outputFile)
        return
    }

    const options = { quality: 80 }
    const outputFile = path.join(outputSubDir, `${baseName}${extName}`)
    const outputFileWebp = path.join(outputSubDir, `${baseName}.webp`)
    const outputFileAvif = path.join(outputSubDir, `${baseName}.avif`)

    await Promise.all([
        sharp(file).jpeg(options).toFile(outputFile),
        sharp(file).webp(options).toFile(outputFileWebp),
        sharp(file).avif().toFile(outputFileAvif)
    ])
}

export function dev() {
    watch(paths.scss, css)
    watch(paths.js, js)
    watch(paths.img, {
        awaitWriteFinish: {
            stabilityThreshold: 500,
            pollInterval: 100
        },
        usePolling: true
    }, imagenes)
}

export default series(parallel(js, css, imagenes), dev)
