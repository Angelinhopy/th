module.exports = {
  "transpileDependencies": [
    "vuetify"
  ],
  devServer: {
    proxy: process.env.NODE_ENV === 'production'
    ? 'http://localhost/'
    : 'http://localhost/dev/th/api/v1',
    /*proxy: {
      '/': {
        target: 'http://localhost/dev/th/api/v1',
        ws: true,
        changeOrigin: true,
      }
    }*/
  },
}