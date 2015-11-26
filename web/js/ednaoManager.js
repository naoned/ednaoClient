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
    var currentPos = {'x' : 0, 'y' : 0};

    function _init(handler) {
      iframe = document.getElementById('ednao');
      baseUrl = iframe.getAttribute('data-base-url');
      if (baseUrl === undefined)   {
        console.log('Error : Help based url is not defined');
      }
      window.addEventListener('message', _onmessage, true);
    }

    function _setPositionToIframe() {
      iframe.contentWindow.postMessage({
        'type': 'setCurrentPos',
        'curPos': _getOffset(iframe)
      }, '*');
    }

    function show() {
      iframe.style.display = 'block';
      _setPositionToIframe();
    }

    function hide() {
      iframe.style.display = 'none';
    }

    // Change page for help in
    function goToContext(context) {
      // cast to string
      context = context + '';
      var contextPath = iframe.getAttribute('data-context-path');
      if (contextPath === undefined) {
        console.log('Error : Help context path is not defined');
      }
      iframe.src = baseUrl+'/'+contextPath+context;
      show();
    }

    function _iframeMouseUp(e){
      iframe.style.width = '400px';
      iframe.style.height = '600px';
      iframe.style.left = e.data.curPos.x + 'px';
      iframe.style.top = e.data.curPos.y + 'px';
    }

    function _iframeMouseDown(e){
      iframe.style.width = '100%';
      iframe.style.height = '100%';
      iframe.style.left = 0;
      iframe.style.top = 0;
    }

    function _onmessage(e){
      if (e.data.type == 'moveIframeDown') {
        _iframeMouseDown(e);
      }
      if (e.data.type == 'moveIframeUp') {
        _iframeMouseUp(e);
      }
      if (e.data.type == 'checkIframeMode') {
        _setPositionToIframe(e);
      }
    }

    function _getOffset(el) {
      var _x = 0;
      var _y = 0;
      while( el && !isNaN( el.offsetLeft ) && !isNaN( el.offsetTop ) ) {
        _x += el.offsetLeft - el.scrollLeft;
        _y += el.offsetTop - el.scrollTop;
        el = el.offsetParent;
      }
      return { x: _x, y: _y };
    }

    _init();

    // Expose methods
    var exports = {};
    exports.goToContext = goToContext;
    exports.show = show;
    exports.hide = hide;

    return exports;
  })();

  window.ednaoManager = ednaoManager;
  return ednaoManager;
})(this);


