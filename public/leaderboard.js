(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["leaderboard"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Leaderboard/Leaderboard.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Leaderboard/Leaderboard.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vuetify_lib__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuetify/lib */ "./node_modules/vuetify/lib/index.js");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'Leaderboard',
  components: {
    VCard: vuetify_lib__WEBPACK_IMPORTED_MODULE_0__["VCard"],
    VCardTitle: vuetify_lib__WEBPACK_IMPORTED_MODULE_0__["VCardTitle"],
    VCardText: vuetify_lib__WEBPACK_IMPORTED_MODULE_0__["VCardText"],
    VSimpleTable: vuetify_lib__WEBPACK_IMPORTED_MODULE_0__["VSimpleTable"],
    VAvatar: vuetify_lib__WEBPACK_IMPORTED_MODULE_0__["VAvatar"]
  },
  computed: {},
  data: function data() {
    return {
      leaderboard: []
    };
  },
  mounted: function mounted() {
    var _this = this;

    this.$axios.get('/leaderboard', {
      params: {
        api_token: window.userApiToken
      }
    }).then(function (response) {
      _this.leaderboard = response.data.data;
    });
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Leaderboard/Leaderboard.vue?vue&type=template&id=731291b0&scoped=true&":
/*!**************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Leaderboard/Leaderboard.vue?vue&type=template&id=731291b0&scoped=true& ***!
  \**************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "v-card",
    { attrs: { color: "white" } },
    [
      _c("v-card-title", [_vm._v("Classement")]),
      _vm._v(" "),
      _c(
        "v-card-text",
        [
          _c("v-simple-table", {
            scopedSlots: _vm._u([
              {
                key: "default",
                fn: function() {
                  return [
                    _c("thead", [
                      _c("tr", [
                        _c("th", { staticClass: "text-left" }, [_vm._v("Nom")]),
                        _vm._v(" "),
                        _c("th", { staticClass: "text-left" }, [
                          _vm._v("Pointage")
                        ]),
                        _vm._v(" "),
                        _c("th", { staticClass: "text-left" }, [
                          _vm._v("Nombre de partie jouées")
                        ]),
                        _vm._v(" "),
                        _c("th", { staticClass: "text-left" }, [
                          _vm._v("Moyenne")
                        ])
                      ])
                    ]),
                    _vm._v(" "),
                    _c(
                      "tbody",
                      _vm._l(_vm.leaderboard, function(player) {
                        return _c("tr", { key: player.id }, [
                          _c(
                            "td",
                            [
                              _c(
                                "v-avatar",
                                {
                                  staticClass: "mr-1",
                                  attrs: { size: "24px" }
                                },
                                [
                                  _c("img", {
                                    attrs: {
                                      src: player.avatar,
                                      alt: player.name
                                    }
                                  })
                                ]
                              ),
                              _vm._v(
                                "\n                        " +
                                  _vm._s(player.name) +
                                  "\n                    "
                              )
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c("td", [_vm._v(_vm._s(player.reputation))]),
                          _vm._v(" "),
                          _c("td", [_vm._v(_vm._s(player.numberOfGames))]),
                          _vm._v(" "),
                          _c("td", [
                            _vm._v(
                              _vm._s(
                                Math.round(
                                  player.reputation / player.numberOfGames
                                )
                              )
                            )
                          ])
                        ])
                      }),
                      0
                    )
                  ]
                },
                proxy: true
              }
            ])
          })
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/Leaderboard/Leaderboard.vue":
/*!*************************************************************!*\
  !*** ./resources/js/components/Leaderboard/Leaderboard.vue ***!
  \*************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Leaderboard_vue_vue_type_template_id_731291b0_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Leaderboard.vue?vue&type=template&id=731291b0&scoped=true& */ "./resources/js/components/Leaderboard/Leaderboard.vue?vue&type=template&id=731291b0&scoped=true&");
/* harmony import */ var _Leaderboard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Leaderboard.vue?vue&type=script&lang=js& */ "./resources/js/components/Leaderboard/Leaderboard.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Leaderboard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Leaderboard_vue_vue_type_template_id_731291b0_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Leaderboard_vue_vue_type_template_id_731291b0_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "731291b0",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Leaderboard/Leaderboard.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Leaderboard/Leaderboard.vue?vue&type=script&lang=js&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/Leaderboard/Leaderboard.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Leaderboard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Leaderboard.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Leaderboard/Leaderboard.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Leaderboard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Leaderboard/Leaderboard.vue?vue&type=template&id=731291b0&scoped=true&":
/*!********************************************************************************************************!*\
  !*** ./resources/js/components/Leaderboard/Leaderboard.vue?vue&type=template&id=731291b0&scoped=true& ***!
  \********************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Leaderboard_vue_vue_type_template_id_731291b0_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Leaderboard.vue?vue&type=template&id=731291b0&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Leaderboard/Leaderboard.vue?vue&type=template&id=731291b0&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Leaderboard_vue_vue_type_template_id_731291b0_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Leaderboard_vue_vue_type_template_id_731291b0_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);