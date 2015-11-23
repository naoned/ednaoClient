/*
 Copyright 2015 Naoned
 */

(function(window) {

  if (!!window.ednaoManager) {
    return window.ednaoManager;
  }

  var document = window.document;

  var ednaoManager = (function() {

    var iframe;
    var baseUrl;

    function _init() {
      iframe = document.getElementById('ednao');
      baseUrl = iframe.getAttribute('data-base-url');
      if (baseUrl === undefined) {
        console.log('Error : Help based url is not defined');
      }
    }

    // Change page for help in
    function goToContext(context) {
      // cast to string
      context = context + '';
      var contextPath = iframe.getAttribute('data-context-path');
      if (contextPath === undefined) {
        console.log('Error : Help context path is not defined');
      }
      iframe.src = baseUrl+'/'+contextPath+'/'+context;
    }

    // Expose methods
    var exports = {};
    exports.goToContext = goToContext;

    _init();

    return exports;
  })();

  window.ednaoManager = ednaoManager;
  return ednaoManager;
})(this);
