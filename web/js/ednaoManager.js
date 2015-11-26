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
    var isInit = false;
    var currentPos = {'x' : 0, 'y' : 0};
    var contextPath;

    function _init(handler) {
      if (isInit) {
        return;
      }
      iframe = document.getElementById('ednao');
      if (iframe === undefined || iframe === null) {
        return;
      }
      baseUrl = iframe.getAttribute('data-base-url');
      if (baseUrl === undefined)   {
        _error('Help based url is not defined');
        return;
      }
      contextPath = iframe.getAttribute('data-context-path');
      if (contextPath === undefined) {
        _error('Help context path is not defined');
      }

      var x = _getCookie('ednao_x');
      if (x) { iframe.style.left = x + 'px'; }
      var y = _getCookie('ednao_y');
      if (y) { iframe.style.top = y + 'px'; }
      isInit = true;
      if (_getCookie('ednao_visible')) {
        show();
      }
      window.addEventListener('message', _onmessage, true);
    }

    function _sendPositionToIframe() {
      iframe.contentWindow.postMessage({
        'type': 'setCurrentPos',
        'curPos': _getOffset(iframe)
      }, '*');
    }

    function show(url) {
      _init();
      _setCookie('ednao_visible', true);
      if (!url) {
        url = _getCookie('ednao_url');
      }
      if (!url) {
        var loginPath = iframe.getAttribute('data-login-path');
        if (loginPath === undefined)   {
          _error('Help login path is not defined');
          return;
        }
        url = baseUrl + loginPath;
      }
      if (url != iframe.src) {
        iframe.src = url;
      }
      iframe.style.display = 'block';
      _sendPositionToIframe();
    }

    function hide() {
      iframe.contentWindow.postMessage({
        'type': 'resetScroll',
      }, '*');
      _unsetCookie('ednao_visible');
      iframe.style.display = 'none';
    }

    // Change page for help in
    function goToContext(context) {
      show(baseUrl+contextPath+context);
    }

    function _iframeMouseUp(curPos){
      iframe.style.width = '400px';
      iframe.style.height = '600px';
      iframe.style.left = curPos.x + 'px';
      iframe.style.top = curPos.y + 'px';
      _setCookie('ednao_x', curPos.x);
      _setCookie('ednao_y', curPos.y);
    }

    function _iframeMouseDown(){
      iframe.style.width = '100%';
      iframe.style.height = '100%';
      iframe.style.left = 0;
      iframe.style.top = 0;
    }

    function _onmessage(e){
      if (e.data.type == 'moveIframeDown') {
        _iframeMouseDown();
      }
      if (e.data.type == 'moveIframeUp') {
        _iframeMouseUp(e.data.curPos);
      }
      if (e.data.type == 'checkIframeMode') {
        _saveUrl(e.data.url);
        _sendPositionToIframe();
      }
      if (e.data.type == 'closeIframe') {
        hide();
      }
    }

    function _unsetCookie(cname, exMin) {
      _setCookie(cname, '', exMin)
    }

    function _setCookie(cname, cvalue, exMin) {
      var d = new Date();
      if (exMin === undefined) {
        exMin = 60;
      }
      d.setTime(d.getTime() + (exMin*60*1000));
      var expires = "expires="+d.toUTCString();
      document.cookie = cname + "=" + cvalue + "; " + expires;
    }

    function _getCookie(cname) {
      var name = cname + "=";
      var ca = document.cookie.split(';');
      for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
      }
      return "";
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

    function _saveUrl(url) {
      _setCookie('ednao_url', url);
    }

    function _error(message) {
      console.log('Error: '+ message);
      alert('Une erreur est survenue dans le module d’aide.');
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


