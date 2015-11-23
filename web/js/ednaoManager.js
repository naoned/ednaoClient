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
    var decX;
    var decY;
    var div;

    function _init() {
      _addListeners();
      div = document.getElementById('ednao');
      iframe = document.getElementById('ednao-iframe');
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

    function _addListeners(){
      document.getElementById('ednao-handle').addEventListener('mousedown', _mouseDown, false);
      window.addEventListener('mouseup', _mouseUp, false);
    }

    function _mouseUp()
    {
      window.removeEventListener('mousemove', _divMove, true);
    }

    function _mouseDown(e){
      decY = e.clientY - div.offsetTop;
      decX = e.clientX - div.offsetLeft;
      window.addEventListener('mousemove', _divMove, true);
    }

    function _divMove(e){
      div.style.position = 'absolute';
      div.style.top = (e.clientY - decY) + 'px';
      div.style.left = (e.clientX - decX) + 'px';
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


