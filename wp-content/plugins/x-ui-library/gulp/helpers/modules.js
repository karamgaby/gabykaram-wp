const fs = require('fs');
const path_module = require('path');
const { path} = require('../config');

/**
 * getModules helper function for collecting all modules
 */
const getModules = () => {
  return fs.readdirSync(path.modules.source)
    .filter(function (module) {
      if (!module.includes("_", 0)) {
        return fs.statSync(path_module.join(`./${path.modules.source}`, module)).isDirectory();
      }
    });
}



/**
 * getModuleJsons helper function for collecting all modules _.json files
 */
var getModuleJsons = () => {
  var jsons = [];
  var modules = getModules();

  for (let i = 0; i < modules.length; i++) {
    if (!modules[i].includes("_", 0) && !modules[i].includes(".")) {
      jsons.push({
        'name': modules[i],
        'json': require(`../../${path.modules.source}` + modules[i] + '/_.json'),
      });
    }
  }
  return jsons;
}

module.exports = {
  getModules,
  getModuleJsons,
}
