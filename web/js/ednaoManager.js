/*
 Copyright 2015 Naoned
 */
/* eslint-disable */
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
    var isIE = /*@cc_on!@*/false || !!document.documentMode;
    var isSafari = navigator.vendor && navigator.vendor.indexOf('Apple') > -1 &&
                   navigator.userAgent && !navigator.userAgent.match('CriOS');

    function _initVars() {
        if (isInit) {
            return true;
        }
        iframe = document.getElementById('ednao');
        if (typeof iframe === 'undefined' || iframe === null) {
            return false;
        }
        contextPath = iframe.getAttribute('data-context-path');
        baseUrl = iframe.getAttribute('data-base-url');
        if (typeof baseUrl === 'undefined')   {
            _error('Help based url is not defined');
            return false;
        }
        if (typeof contextPath === 'undefined') {
            _error('Help context path is not defined');
        }
        isInit = true;

        return true;
    }

    function _init() {
        if (isInit) {
            return;
          }
        var res = _initVars();
        if (!res) {
            return;
        }
      var x = localStorage.getItem('ednao_x');
      if (x) { iframe.style.left = x + 'px'; }
      var y = localStorage.getItem('ednao_y');
      if (y) { iframe.style.top = y + 'px'; }

      if (localStorage.getItem('ednao_visible')) {
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
      if (isIE || isSafari) {
        _initVars();
        var win = window.open(getURL(url), '_blank');
        if (win) {
          //Browser has allowed it to be opened
          win.focus();
        } else {
          //Browser has blocked it
          console.log('Help window blocked by browser.');
        }
      } else {
        _init();
        localStorage.setItem('ednao_visible', true);
        _setIframeSrc(url)
        iframe.addEventListener("load", function() {
          _sendPositionToIframe();
          iframe.style.display = 'block';
        });
      }
    }

    function _setIframeSrc(url) {
      iframe.src = getURL(url);
    }

    function getURL(url) {
      if (!url) {
        url = localStorage.getItem('ednao_url');
      }

      if (!url || typeof url === 'undefined') {
        var loginPath = iframe.getAttribute('data-login-path');
        if (typeof loginPath === 'undefined')   {
          _error('Help login path is not defined');
          return;
        }
        url = baseUrl + loginPath;
      }

      return url;
    }

    function hide() {
      iframe.contentWindow.postMessage({
        'type': 'resetScroll',
      }, '*');
      localStorage.removeItem('ednao_visible');
      localStorage.removeItem('ednao_url');
      iframe.style.display = 'none';
    }

    // Change page for help in
    function goToContext(context) {
        if (isIE || isSafari) {
            return show();
        }
        var url = baseUrl;
        if (typeof contextPath !== 'undefined') {
            url += contextPath;
            if (typeof context !== 'undefined') {
                url += context;
            }
        }
        show(url);
    }

    function reset() {
      localStorage.removeItem('ednao_url');
      _setIframeSrc();
    }

    function _iframeMouseUp(curPos){
      iframe.style.width = '400px';
      iframe.style.height = '600px';
      iframe.style.left = curPos.x + 'px';
      iframe.style.top = curPos.y + 'px';
      localStorage.setItem('ednao_x', curPos.x);
      localStorage.setItem('ednao_y', curPos.y);

      //  refocus when popup is out of screen
      if(curPos.x < -200){
        iframe.style.left = "-200" + 'px';
      } else if(curPos.x > window.innerWidth - 200) {
        iframe.style.left = window.innerWidth - 200  + 'px';
      } else if(curPos.y > window.outerHeight - 300){
        iframe.style.top = window.outerHeight - 300  + 'px';
      }
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
      var isOnContextPage = new RegExp('^http(s)?:\/\/.*?' + escapeRegExp(contextPath));
      // We don't save if url is the context page. It's the default and if we save the context page will not reload correctly.
      if(!isOnContextPage.test(url)) {
        localStorage.setItem('ednao_url', url);
      }
    }

    function _error(message) {
      console.log('Error: '+ message);
      alert('Une erreur est survenue dans le module d’aide.');
    }

    function escapeRegExp(str) {
      return str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
    }

    document.onreadystatechange = function() {
      if (document.readyState=="complete") {
        if (!isIE && !isSafari) {
            _init(true);
        }
      }
    };

    // Expose methods
    var exports = {};
    exports.goToContext = goToContext;
    exports.show = show;
    exports.hide = hide;
    exports.reset = reset;

    return exports;
  })();

  window.ednaoManager = ednaoManager;
  return ednaoManager;
})(this);
