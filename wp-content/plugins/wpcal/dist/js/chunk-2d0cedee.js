(window["wpcalMainWebpackJsonp"] = window["wpcalMainWebpackJsonp"] || []).push([["chunk-2d0cedee"],{

/***/ "60fd":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_es_array_find_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("7db0");
/* harmony import */ var core_js_modules_es_array_find_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_find_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("d3b7");
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__("2b0e");
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__("2f62");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__("bc3a");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var lodash_es__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__("5c8a");
/* harmony import */ var _store_common_module_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__("cdab");






vue__WEBPACK_IMPORTED_MODULE_2__["default"].use(vuex__WEBPACK_IMPORTED_MODULE_3__[/* default */ "a"]);

/* harmony default export */ __webpack_exports__["default"] = (new vuex__WEBPACK_IMPORTED_MODULE_3__[/* default */ "a"].Store({
  strict: true,
  modules: {
    common: _store_common_module_js__WEBPACK_IMPORTED_MODULE_6__[/* default */ "a"]
  },
  state: {
    client_end: "admin",
    store: {
      license_info: null,
      current_admin_details: {},
      current_admin_notices: null,
      managed_active_admins_details: [],
      // futuristic - current wpcal admin type is administrator only
      wpcal_site_urls: {},
      is_admin_end_access_granted: true,
      admin_main_nonce: null
    }
  },
  mutations: {
    set_license_info: function set_license_info(state, value) {
      state.store.license_info = value;
    },
    set_managed_active_admins_details: function set_managed_active_admins_details(state, value) {
      state.store.managed_active_admins_details = value;
    },
    set_store_by_obj: function set_store_by_obj(state, value_obj) {
      for (var prop in value_obj) {
        if (state.store.hasOwnProperty(prop)) {
          state.store[prop] = value_obj[prop];
        }
      }
    }
  },
  getters: {
    // get_client: state => state.client,
    // get_store: state => state.store,
    get_license_info: function get_license_info(state) {
      return state.store.license_info;
    },
    get_current_admin_details: function get_current_admin_details(state) {
      return state.store.current_admin_details;
    },
    get_current_admin_notices: function get_current_admin_notices(state) {
      return state.store.current_admin_notices;
    },
    get_managed_active_admins_details: function get_managed_active_admins_details(state) {
      return state.store.managed_active_admins_details;
    },
    get_managed_active_admins_for_host_filter: function get_managed_active_admins_for_host_filter(state) {
      var admins = Object(lodash_es__WEBPACK_IMPORTED_MODULE_5__[/* default */ "a"])(state.store.managed_active_admins_details);

      if (Array.isArray(admins)) {
        var all_admin_as_admin = {
          admin_user_id: "0",
          admin_type: "administrator",
          status: "1",
          name: "All",
          firstname: "",
          display_name: "All",
          user_email: "All"
        };
        admins.unshift(all_admin_as_admin);
      }

      return admins;
    },
    get_admin_details: function get_admin_details(state) {
      return function (admin_user_id) {
        var admin_details = {};
        var admins = Object(lodash_es__WEBPACK_IMPORTED_MODULE_5__[/* default */ "a"])(state.store.managed_active_admins_details);
        var found_admin_details = admins.find(function (_admin_details) {
          return _admin_details.admin_user_id == admin_user_id;
        });
        return found_admin_details ? found_admin_details : admin_details;
      };
    },
    get_wpcal_site_urls: function get_wpcal_site_urls(state) {
      return state.store.wpcal_site_urls;
    },
    get_is_admin_end_access_granted: function get_is_admin_end_access_granted(state) {
      return state.store.is_admin_end_access_granted;
    },
    get_admin_main_nonce: function get_admin_main_nonce(state) {
      return state.store.admin_main_nonce;
    }
  },
  actions: {
    load_managed_active_admins_details: function load_managed_active_admins_details(context) {
      var wpcal_request = {};
      var action_managed_active_admins_details = "get_managed_active_admins_details_for_current_admin";
      wpcal_request[action_managed_active_admins_details] = "dummy__";
      var post_data = {
        action: context.getters.get_ajax_main_action,
        wpcal_request: wpcal_request
      };
      axios__WEBPACK_IMPORTED_MODULE_4___default.a.post(window.wpcal_ajax.ajax_url, post_data, {
        params: {
          _remove_options_before_call: {
            background_call: true
          }
        }
      }).then(function (response) {
        var _response$data$action;

        if (response.data[action_managed_active_admins_details].status === "success" && (_response$data$action = response.data[action_managed_active_admins_details]) !== null && _response$data$action !== void 0 && _response$data$action.managed_active_admins_details) {
          context.commit("set_managed_active_admins_details", response.data[action_managed_active_admins_details].managed_active_admins_details);
        }
      }).catch(function (error) {
        console.log(error);
      });
    }
  }
}));

/***/ })

}]);