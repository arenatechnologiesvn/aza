const path = require('path');
const mix = require('laravel-mix');
const CleanWebpackPlugin = require('clean-webpack-plugin');

mix.webpackConfig({
  plugins: [
    new CleanWebpackPlugin(['public/js', 'public/css'])
  ]
});

mix
  .js('resources/assets/js/app.js', 'public/js')
  .sass('resources/assets/sass/app.scss', 'public/css')
  .sourceMaps()
  .disableNotifications();

if (mix.inProduction()) {
  mix.version();

  mix.extract([
    'vue',
    'vform',
    'axios',
    'vuex',
    'jquery',
    'popper.js',
    'vue-i18n',
    'vue-meta',
    'js-cookie',
    'vue-router',
    'vuex-router-sync',
    'element-ui',
    'normalize.css',
    'nprogress'
  ]);
}

mix.webpackConfig({
  plugins: [
    // new BundleAnalyzerPlugin()
  ],
  resolve: {
    extensions: ['.js', '.json', '.vue'],
    alias: {
      '~': path.join(__dirname, './resources/assets/js'),
      '~sass': path.join(__dirname, './resources/assets/sass')
    }
  },
  output: {
    chunkFilename: 'js/[name].[chunkhash].js',
    publicPath: mix.config.hmr ? '//localhost:8080' : '/'
  },
  module: {
    rules: [
      {
        test: /\.pug$/,
        loader: 'pug-plain-loader'
      }
    ]
  },
  node: {
    fs: 'empty'
  }
});
