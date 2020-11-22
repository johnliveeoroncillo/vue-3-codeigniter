require('dotenv').config();

module.exports = {
    devServer: {
        proxy: {
            "/api": {
                target: process.env.VUE_APP_ROOTAPI,
                changeOrigin: true,
                pathRewrite: {
                    '^/api' : ''
                }
            }
        },
    },
    publicPath: process.env.NODE_ENV === 'production'
    ? '/vue-ci/'
    : '/'
}