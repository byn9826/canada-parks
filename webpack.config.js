var webpack = require('webpack');

module.exports = {
    entry: {
        attitude: "./static/source/Attitude.jsx",
        search: "./static/source/Search.jsx",
        adminParks: "./static/source/AdminParks.jsx",
    },
    output: {
        path: __dirname + '/static/source/',
        filename: '[name].bundle.js'
    },
    module: {
        loaders: [
	        {
	        	test: /\.(js|jsx)$/,
		        exclude: /(node_modules|bower_components)/,
		        loader: 'babel-loader',
		        query: {
		            presets: ["react", "es2015"]
		        }
	        }
        ]
    },
    resolve: {
        extensions: ['.js', '.jsx']
    },
    plugins : [
        new webpack.optimize.UglifyJsPlugin({
            compress: {
                warnings: false,
            },
            output: {
                comments: false
            }
        })
    ]
}
