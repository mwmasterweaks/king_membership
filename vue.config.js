module.exports = {
  devServer: {
    proxy: {
      "/api": {
        target: "http://localhost:8000", // Replace this with the actual URL of your backend server
        changeOrigin: true,
        pathRewrite: {
          "^/api": "/api" // If your backend API does not have a /api prefix, adjust this accordingly
        }
      }
    }
  }
};
