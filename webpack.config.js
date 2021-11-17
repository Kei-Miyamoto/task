const path = require('path')
module.exports = {
  _module: {
    rules: [{
      test: /\.json$/,
      loader: "json-loader",
      type: "javascript/auto"
    }]
  },
  get module() {
    return this._module
  },
  set module(value) {
    this._module = value
  },

}