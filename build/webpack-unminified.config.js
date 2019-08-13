const path = require('path')
const isdev = require('isdev')
const webpack = require('webpack')
const autoprefixer = require('autoprefixer')

const CopyPlugin = require('copy-webpack-plugin')
const CleanPlugin = require('clean-webpack-plugin')
const StyleLintPlugin = require('stylelint-webpack-plugin')
const ExtractTextPlugin = require('extract-text-webpack-plugin')
const { default: ImageminPlugin } = require('imagemin-webpack-plugin')

const vueRule = require('./rules/vue')
const sassRule = require('./rules/sass')
const fontsRule = require('./rules/fonts')
const imagesRule = require('./rules/images')
const javascriptRule = require('./rules/javascript')
const externalFontsRule = require('./rules/external.fonts')
const externalImagesRule = require('./rules/external.images')


const config = require('./app-unminified.config')


module.exports = {
  /**
   * Should the source map be generated?
   *
   * @type {string|undefined}
   */
  devtool: (isdev && config.settings.sourceMaps) ? 'source-map' : undefined,

  /**
   * Application entry files for building.
   *
   * @type {Object}
   */
  entry: config.assets,

  /**
   * Output settings for application scripts.
   *
   * @type {Object}
   */
  output: {
    path: config.paths.public,
    filename: config.outputs.javascript.filename
  },

  /**
   * External objects which should be accessible inside application scripts.
   *
   * @type {Object}
   */
  externals: config.externals,

  /**
   * Custom modules resolving settings.
   *
   * @type {Object}
   */
  resolve: config.resolve,

  /**
   * Performance settings to speed up build times.
   *
   * @type {Object}
   */
  performance: {
    hints: false
  },

  /**
   * Build rules to handle application assset files.
   *
   * @type {Object}
   */
  module: {
    rules: [
      sassRule,
      fontsRule,
      javascriptRule,
    ]
  },

  /**
   * Common plugins which should run on every build.
   *
   * @type {Array}
   */
  plugins: [
    new webpack.LoaderOptionsPlugin({ minimize: !isdev }),
    new ExtractTextPlugin(config.outputs.css)
  ]
}

/**
 * Adds Stylelint plugin if
 * linting is configured.
 */
if (config.settings.styleLint) {
  module.exports.plugins.push(
    new StyleLintPlugin(config.settings.styleLint)
  )
}

