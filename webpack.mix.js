const path = require('path');

module.exports = {
  entry: {
    app: './resources/js/app.js',
    bootstrap: './resources/js/bootstrap.js',
    pusher: './resources/js/pusher.min.js',
  },
  output: {
    filename: '[name].bundle.js',
    path: path.resolve(__dirname, 'public/js'),
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-env'],
          },
        },
      },
    ],
  },
  resolve: {
    extensions: ['.js'],
  },
};
