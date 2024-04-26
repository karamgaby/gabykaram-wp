"use strict";!function(e){"object"==typeof exports&&"undefined"!=typeof module?module.exports=e():"function"==typeof define&&define.amd?define(e):("undefined"!=typeof globalThis?globalThis:self).cssVars=e()}(function(){function x(){return(x=Object.assign?Object.assign.bind():function(e){for(var t=1;t<arguments.length;t++){var r,n=arguments[t];for(r in n)Object.prototype.hasOwnProperty.call(n,r)&&(e[r]=n[r])}return e}).apply(this,arguments)}function p(e,t){var t=1<arguments.length&&void 0!==t?t:{},o={mimeType:t.mimeType||null,onBeforeSend:t.onBeforeSend||Function.prototype,onSuccess:t.onSuccess||Function.prototype,onError:t.onError||Function.prototype,onComplete:t.onComplete||Function.prototype},n=Array.isArray(e)?e:[e],s=Array.apply(null,Array(n.length)).map(function(e){return null});function a(e){var t="string"==typeof e,e=t&&"<"===e.trim().charAt(0);return t&&!e}function c(e,t){o.onError(e,n[t],t)}function i(e,t){var r=o.onSuccess(e,n[t],t);s[t]=e=!1===r?"":r||e,-1===s.indexOf(null)&&o.onComplete(s)}var u=document.createElement("a");n.forEach(function(e,t){var r,n;u.setAttribute("href",e),u.href=String(u.href),Boolean(document.all&&!window.atob)&&u.host.split(":")[0]!==location.host.split(":")[0]?u.protocol===location.protocol?((r=new XDomainRequest).open("GET",e),r.timeout=0,r.onprogress=Function.prototype,r.ontimeout=Function.prototype,r.onload=function(){var e=r.responseText;a(e)?i(e,t):c(r,t)},r.onerror=function(e){c(r,t)},setTimeout(function(){r.send()},0)):(console.warn("Internet Explorer 9 Cross-Origin (CORS) requests must use the same protocol (".concat(e,")")),c(null,t)):((n=new XMLHttpRequest).open("GET",e),o.mimeType&&n.overrideMimeType&&n.overrideMimeType(o.mimeType),o.onBeforeSend(n,e,t),n.onreadystatechange=function(){var e;4===n.readyState&&(e=n.responseText,n.status<400&&a(e)||0===n.status&&a(e)?i(e,t):c(n,t))},n.send())})}function t(e){var s=/\/\*[\s\S]+?\*\//g,a=/(?:@import\s*)(?:url\(\s*)?(?:['"])([^'"]*)(?:['"])(?:\s*\))?(?:[^;]*;)/g,f={rootElement:e.rootElement||document,include:e.include||'style,link[rel="stylesheet"]',exclude:e.exclude||null,filter:e.filter||null,skipDisabled:!1!==e.skipDisabled,useCSSOM:e.useCSSOM||!1,onBeforeSend:e.onBeforeSend||Function.prototype,onSuccess:e.onSuccess||Function.prototype,onError:e.onError||Function.prototype,onComplete:e.onComplete||Function.prototype},r=Array.apply(null,f.rootElement.querySelectorAll(f.include)).filter(function(e){return t=f.exclude,!(e.matches||e.matchesSelector||e.webkitMatchesSelector||e.mozMatchesSelector||e.msMatchesSelector||e.oMatchesSelector).call(e,t);var t}),c=Array.apply(null,Array(r.length)).map(function(e){return null});function i(){var e;-1===c.indexOf(null)&&(c.reduce(function(e,t,r){return""===t&&e.push(r),e},[]).reverse().forEach(function(t){return[r,c].forEach(function(e){return e.splice(t,1)})}),e=c.join(""),f.onComplete(e,c,r))}function u(e,r,n,t){var o=f.onSuccess(e,n,t);!function n(o,s,a,c){var i=4<arguments.length&&void 0!==arguments[4]?arguments[4]:[],u=5<arguments.length&&void 0!==arguments[5]?arguments[5]:[],l=d(o,a,u);l.rules.length?p(l.absoluteUrls,{onBeforeSend:function(e,t,r){f.onBeforeSend(e,s,t)},onSuccess:function(r,e,t){var n=f.onSuccess(r,s,e),o=d(r=!1===n?"":n||r,e,u);return o.rules.forEach(function(e,t){r=r.replace(e,o.absoluteRules[t])}),r},onError:function(e,t,r){i.push({xhr:e,url:t}),u.push(l.rules[r]),n(o,s,a,c,i,u)},onComplete:function(e){e.forEach(function(e,t){o=o.replace(l.rules[t],e)}),n(o,s,a,c,i,u)}}):c(o,i)}(e=void 0!==o&&!1===Boolean(o)?"":o||e,n,t,function(e,t){null===c[r]&&(t.forEach(function(e){return f.onError(e.xhr,n,e.url)}),!f.filter||f.filter.test(e)?c[r]=e:c[r]="",i())})}function d(e,n,t){var r=2<arguments.length&&void 0!==t?t:[],o={};return o.rules=(e.replace(s,"").match(a)||[]).filter(function(e){return-1===r.indexOf(e)}),o.urls=o.rules.map(function(e){return e.replace(a,"$1")}),o.absoluteUrls=o.urls.map(function(e){return l(e,n)}),o.absoluteRules=o.rules.map(function(e,t){var r=o.urls[t],t=l(o.absoluteUrls[t],n);return e.replace(r,t)}),o}r.length?r.forEach(function(o,s){var a=o.getAttribute("href"),e=o.getAttribute("rel"),e="link"===o.nodeName.toLowerCase()&&a&&e&&-1!==e.toLowerCase().indexOf("stylesheet"),t=!1!==f.skipDisabled&&o.disabled,r="style"===o.nodeName.toLowerCase();e&&!t?-1!==a.indexOf("data:text/css")?(e=decodeURIComponent(a.substring(a.indexOf(",")+1)),u(e=f.useCSSOM?Array.apply(null,o.sheet.cssRules).map(function(e){return e.cssText}).join(""):e,s,o,location.href)):p(a,{mimeType:"text/css",onBeforeSend:function(e,t,r){f.onBeforeSend(e,o,t)},onSuccess:function(e,t,r){var n=l(a);u(e,s,o,n)},onError:function(e,t,r){c[s]="",f.onError(e,o,t),i()}}):r&&!t?(e=o.textContent,u(e=f.useCSSOM?Array.apply(null,o.sheet.cssRules).map(function(e){return e.cssText}).join(""):e,s,o,location.href)):(c[s]="",i())}):f.onComplete("",[])}function l(e,t){var r=document.implementation.createHTMLDocument(""),n=r.createElement("base"),o=r.createElement("a");return r.head.appendChild(n),r.body.appendChild(o),n.href=t||document.baseURI||(document.querySelector("base")||{}).href||location.href,o.href=e,o.href}var m=e;function e(e,t,r){var n=s(e=e instanceof RegExp?o(e,r):e,t=t instanceof RegExp?o(t,r):t,r);return n&&{start:n[0],end:n[1],pre:r.slice(0,n[0]),body:r.slice(n[0]+e.length,n[1]),post:r.slice(n[1]+t.length)}}function o(e,t){t=t.match(e);return t?t[0]:null}function s(e,t,r){var n,o,s,a,c,i=r.indexOf(e),u=r.indexOf(t,i+1),l=i;if(0<=i&&0<u){if(e===t)return[i,u];for(n=[],s=r.length;0<=l&&!c;)l==i?(n.push(l),i=r.indexOf(e,l+1)):1==n.length?c=[n.pop(),u]:((o=n.pop())<s&&(s=o,a=u),u=r.indexOf(t,l+1)),l=i<u&&0<=i?i:u;n.length&&(c=[s,a])}return c}function O(o,e){var s=x({},{preserveStatic:!0,removeComments:!1},1<arguments.length&&void 0!==e?e:{});function a(e){throw new Error("CSS parse error: ".concat(e))}function c(e){e=e.exec(o);if(e)return o=o.slice(e[0].length),e}function i(){return c(/^{\s*/)}function u(){return c(/^}/)}function l(){c(/^\s*/)}function f(){for(var e,t=[];e=function(){if(l(),"/"===o[0]&&"*"===o[1]){for(var e,t=2;o[t]&&("*"!==o[t]||"/"!==o[t+1]);)t++;return o[t]?(e=o.slice(2,t),o=o.slice(t+2),{type:"comment",comment:e}):a("end of comment is missing")}}();)t.push(e);return s.removeComments?[]:t}function d(){for(l();"}"===o[0];)a("extra closing bracket");var e,t=c(/^(("(?:\\"|[^"])*"|'(?:\\'|[^'])*'|[^{])+)/);if(t)return t=t[0].trim(),/\/\*/.test(t)&&(t=t.replace(/\/\*([^*]|[\r\n]|(\*+([^*/]|[\r\n])))*\*\/+/g,"")),(e=/["']\w*,\w*["']/.test(t))&&(t=t.replace(/"(?:\\"|[^"])*"|'(?:\\'|[^'])*'/g,function(e){return e.replace(/,/g,"‌")})),t=/,/.test(t)?t.split(/\s*(?![^(]*\)),\s*/):[t],e?t.map(function(e){return e.replace(/\u200C/g,",")}):t}function p(){if(!i())return a("missing '{'");for(var e,t=f();e=function(){if("@"===o[0])return n();c(/^([;\s]*)+/);var e,t=/\/\*[^*]*\*+([^/*][^*]*\*+)*\//g,r=c(/^(\*?[-#/*\\\w.]+(\[[0-9a-z_-]+\])?)\s*/);return r?(r=r[0].trim(),c(/^:\s*/)?(e=c(/^((?:\/\*.*?\*\/|'(?:\\'|.)*?'|"(?:\\"|.)*?"|\((\s*'(?:\\'|.)*?'|"(?:\\"|.)*?"|[^)]*?)\s*\)|[^};])+)/),r={type:"declaration",property:r.replace(t,""),value:e?e[0].replace(t,"").trim():""},c(/^[;\s]*/),r):a("property missing ':'")):void 0}();)t.push(e),t=t.concat(f());return u()?t:a("missing '}'")}function t(){var e=c(/^@([-\w]+)?keyframes\s*/);if(e){var t=e[1];if(!(e=c(/^([-\w]+)\s*/)))return a("@keyframes missing name");var r,e=e[1];if(!i())return a("@keyframes missing '{'");for(var n=f();r=function(){l();for(var e,t=[];e=c(/^((\d+\.\d+|\.\d+|\d+)%?|[a-z]+)\s*/);)t.push(e[1]),c(/^,\s*/);if(t.length)return{type:"keyframe",values:t,declarations:p()}}();)n.push(r),n=n.concat(f());return u()?{type:"keyframes",name:e,vendor:t,keyframes:n}:a("@keyframes missing '}'")}}function n(){var e;if(l(),"@"===o[0])return!(e=function(){var e=c(/^@(import|charset|namespace)\s*([^;]+);/);if(e)return{type:e[1],name:e[2].trim()}}()||function(){if(c(/^@font-face\s*/))return{type:"font-face",declarations:p()}}()||function(){var e=c(/^@media([^{]+)*/);if(e)return{type:"media",media:(e[1]||"").trim(),rules:r()}}()||t()||function(){var e=c(/^@supports *([^{]+)/);if(e)return{type:"supports",supports:e[1].trim(),rules:r()}}()||function(){var e=c(/^@([-\w]+)?document *([^{]+)/);if(e)return{type:"document",document:e[2].trim(),vendor:e[1]?e[1].trim():null,rules:r()}}()||function(){var e=c(/^@custom-media\s+(--[^\s]+)\s*([^{;]+);/);if(e)return{type:"custom-media",name:e[1].trim(),media:e[2].trim()}}()||function(){if(c(/^@host\s*/))return{type:"host",rules:r()}}()||function(){if(c(/^@page */))return{type:"page",selectors:d()||[],declarations:p()}}()||function(){var e=c(/@(top|bottom|left|right)-(left|center|right|top|middle|bottom)-?(corner)?\s*/);if(e)return{type:"page-margin-box",name:"".concat(e[1],"-").concat(e[2])+(e[3]?"-".concat(e[3]):""),declarations:p()}}())||s.preserveStatic||(e.declarations?e.declarations.some(function(e){return/var\(/.test(e.value)}):(e.keyframes||e.rules||[]).some(function(e){return(e.declarations||[]).some(function(e){return/var\(/.test(e.value)})}))?e:{}}function r(e){if(!e&&!i())return a("missing '{'");for(var t,r=f();o.length&&(e||"}"!==o[0])&&(t=n()||function(){if(!s.preserveStatic){var e=m("{","}",o);if(e){var t=/:(?:root|host)(?![.:#(])/.test(e.pre)&&/--\S*\s*:/.test(e.body),r=/var\(/.test(e.body);if(!t&&!r)return o=o.slice(e.end+1),{}}}var n=d()||[],t=s.preserveStatic?p():p().filter(function(e){var t=n.some(function(e){return/:(?:root|host)(?![.:#(])/.test(e)})&&/^--\S/.test(e.property),e=/var\(/.test(e.value);return t||e});return n.length||a("selector missing"),{type:"rule",selectors:n,declarations:t}}());)t.type&&r.push(t),r=r.concat(f());return e||u()?r:a("missing '}'")}return{type:"stylesheet",stylesheet:{rules:r(!0),errors:[]}}}function A(e,t){var n=x({},{parseHost:!1,store:{},onWarning:function(){}},1<arguments.length&&void 0!==t?t:{}),r=new RegExp(":".concat(n.parseHost?"host":"root","$"));(e="string"==typeof e?O(e,n):e).stylesheet.rules.forEach(function(e){"rule"===e.type&&e.selectors.some(function(e){return r.test(e)})&&e.declarations.forEach(function(e,t){var r=e.property,e=e.value;r&&0===r.indexOf("--")&&(n.store[r]=e)})}),n.store}function k(e,t,r){var s=1<arguments.length&&void 0!==t?t:"",a=2<arguments.length?r:void 0,c={charset:function(e){return"@charset "+e.name+";"},comment:function(e){return 0===e.comment.indexOf("__CSSVARSPONYFILL")?"/*"+e.comment+"*/":""},"custom-media":function(e){return"@custom-media "+e.name+" "+e.media+";"},declaration:function(e){return e.property+":"+e.value+";"},document:function(e){return"@"+(e.vendor||"")+"document "+e.document+"{"+n(e.rules)+"}"},"font-face":function(e){return"@font-face{"+n(e.declarations)+"}"},host:function(e){return"@host{"+n(e.rules)+"}"},import:function(e){return"@import "+e.name+";"},keyframe:function(e){return e.values.join(",")+"{"+n(e.declarations)+"}"},keyframes:function(e){return"@"+(e.vendor||"")+"keyframes "+e.name+"{"+n(e.keyframes)+"}"},media:function(e){return"@media "+e.media+"{"+n(e.rules)+"}"},namespace:function(e){return"@namespace "+e.name+";"},page:function(e){return"@page "+(e.selectors.length?e.selectors.join(", "):"")+"{"+n(e.declarations)+"}"},"page-margin-box":function(e){return"@"+e.name+"{"+n(e.declarations)+"}"},rule:function(e){var t=e.declarations;if(t.length)return e.selectors.join(",")+"{"+n(t)+"}"},supports:function(e){return"@supports "+e.supports+"{"+n(e.rules)+"}"}};function n(e){for(var t="",r=0;r<e.length;r++){var n=e[r],o=(a&&a(n),c[n.type](n));o&&(t+=o,o.length)&&n.selectors&&(t+=s)}return t}return n(e.stylesheet.rules)}function _(e,t){var c=x({},{preserveStatic:!0,preserveVars:!1,variables:{},onWarning:function(){}},1<arguments.length&&void 0!==t?t:{});(function e(r,n){r.rules.forEach(function(t){t.rules?e(t,n):t.keyframes?t.keyframes.forEach(function(e){"keyframe"===e.type&&n(e.declarations,t)}):t.declarations&&n(t.declarations,r)})})((e="string"==typeof e?O(e,c):e).stylesheet,function(e,t){for(var r=0;r<e.length;r++){var n=e[r],o=n.type,s=n.property,a=n.value;"declaration"===o&&(c.preserveVars||!s||0!==s.indexOf("--")?-1!==a.indexOf("var(")&&(a=function o(e){var s=1<arguments.length&&void 0!==arguments[1]?arguments[1]:{},a=2<arguments.length?arguments[2]:void 0;if(-1===e.indexOf("var("))return e;var t=m("(",")",e);function r(e){var t=e.split(",")[0].replace(/[\s\n\t]/g,""),r=(e.match(/(?:\s*,\s*){1}(.*)?/)||[])[1],n=Object.prototype.hasOwnProperty.call(s.variables,t)?String(s.variables[t]):void 0,r=n||(r?String(r):void 0),e=a||e;return n||s.onWarning('variable "'.concat(t,'" is undefined')),r&&"undefined"!==r&&0<r.length?o(r,s,e):"var(".concat(e,")")}if(t)return"var"===t.pre.slice(-3)?0===t.body.trim().length?(s.onWarning("var() must contain a non-whitespace string"),e):t.pre.slice(0,-3)+r(t.body)+o(t.post,s):t.pre+"(".concat(o(t.body,s),")")+o(t.post,s);return-1!==e.indexOf("var(")&&s.onWarning('missing closing ")" in the value "'.concat(e,'"')),e}(a,c))!==n.value&&(a=function(r){return(r.match(/calc\(([^)]+)\)/g)||[]).forEach(function(e){var t="calc".concat(e.split("calc").join(""));r=r.replace(e,t)}),r}(a),c.preserveVars?(e.splice(r,0,{type:o,property:s,value:a}),r++):n.value=a):(e.splice(r,1),r--))}}),k(e)}e.range=s;var a="undefined"!=typeof window,f=a&&window.CSS&&window.CSS.supports&&window.CSS.supports("(--a: 0)"),j={group:0,job:0},d={rootElement:a?document:null,shadowDOM:!1,include:"style,link[rel=stylesheet]",exclude:"",variables:{},onlyLegacy:!0,preserveStatic:!0,preserveVars:!1,silent:!1,updateDOM:!0,updateURLs:!0,watch:null,onBeforeSend:function(){},onError:function(){},onWarning:function(){},onSuccess:function(){},onComplete:function(){},onFinally:function(){}},M={cssComments:/\/\*[\s\S]+?\*\//g,cssKeyframes:/@(?:-\w*-)?keyframes/,cssMediaQueries:/@media[^{]+\{([\s\S]+?})\s*}/g,cssUrls:/url\((?!['"]?(?:data|http|\/\/):)['"]?([^'")]*)['"]?\)/g,cssVarDeclRules:/(?::(?:root|host)(?![.:#(])[\s,]*[^{]*{\s*[^}]*})/g,cssVarDecls:/(?:[\s;]*)(-{2}\w[\w-]*)(?:\s*:\s*)([^;]*);/g,cssVarFunc:/var\(\s*--[\w-]/,cssVars:/(?:(?::(?:root|host)(?![.:#(])[\s,]*[^{]*{\s*[^;]*;*\s*)|(?:var\(\s*))(--[^:)]+)(?:\s*[:)])/},V={dom:{},job:{},user:{}},L=!1,v=null,R=0,h=null,y=!1;function T(){var r,n,c,o=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{},s="cssVars(): ",S=x({},d,o);function E(e,t,r,n){!S.silent&&window.console&&console.error("".concat(s).concat(e,"\n"),t),S.onError(e,t,r,n)}function w(e){!S.silent&&window.console&&console.warn("".concat(s).concat(e)),S.onWarning(e)}function C(e){S.onFinally(Boolean(e),f,D()-S.__benchmark)}if(a)if(S.watch)S.watch=d.watch,c=S,window.MutationObserver&&(v&&(v.disconnect(),v=null),(v=new MutationObserver(function(e){e.some(function(e){return a=!1,"attributes"===(t=e).type&&u(t.target)&&!i(t.target)&&(r="disabled"===t.attributeName,n="href"===t.attributeName,o="skip"===t.target.getAttribute("data-cssvars"),s="src"===t.target.getAttribute("data-cssvars"),r?a=!o&&!s:n&&(o?t.target.setAttribute("data-cssvars",""):s&&N(c.rootElement,!0),a=!0)),a||(r=!1,"childList"===(n=e).type&&(o=l(n.target),n="out"===n.target.getAttribute("data-cssvars"),r=o&&!n),r)||(t=!1,t="childList"===e.type?[].slice.call(e.addedNodes).some(function(e){var t=1===e.nodeType&&e.hasAttribute("data-cssvars"),r=l(e)&&M.cssVars.test(e.textContent);return!t&&(u(e)||r)&&!i(e)}):t)||(s=!1,s="childList"===e.type?[].slice.call(e.removedNodes).some(function(e){var t=1===e.nodeType,r=t&&"out"===e.getAttribute("data-cssvars"),t=t&&"src"===e.getAttribute("data-cssvars"),n=t;return(t||r)&&(r=e.getAttribute("data-cssvars-group"),e=c.rootElement.querySelector('[data-cssvars-group="'.concat(r,'"]')),t&&N(c.rootElement,!0),e)&&e.parentNode.removeChild(e),n}):s);var t,r,n,o,s,a})&&T(c)})).observe(document.documentElement,{attributes:!0,attributeFilter:["disabled","href"],childList:!0,subtree:!0})),T(S);else{if(!1===S.watch&&v&&(v.disconnect(),v=null),!S.__benchmark){if(L===S.rootElement)return void function(e){var t=1<arguments.length&&void 0!==arguments[1]?arguments[1]:100;clearTimeout(h),h=setTimeout(function(){e.__benchmark=null,T(e)},t)}(o);var e=[].slice.call(S.rootElement.querySelectorAll('[data-cssvars]:not([data-cssvars="out"])'));S.__benchmark=D(),S.exclude=[v?'[data-cssvars]:not([data-cssvars=""])':'[data-cssvars="out"]',"link[disabled]:not([data-cssvars])",S.exclude].filter(function(e){return e}).join(","),S.variables=function(){var r=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{},n=/^-{2}/;return Object.keys(r).reduce(function(e,t){return e[n.test(t)?t:"--".concat(t.replace(/^-+/,""))]=r[t],e},{})}(S.variables),e.forEach(function(e){var t="style"===e.nodeName.toLowerCase()&&e.__cssVars.text,r=t&&e.textContent!==e.__cssVars.text;t&&r&&(e.sheet&&(e.sheet.disabled=!1),e.setAttribute("data-cssvars",""))}),v||([].slice.call(S.rootElement.querySelectorAll('[data-cssvars="out"]')).forEach(function(e){var t=e.getAttribute("data-cssvars-group");t&&S.rootElement.querySelector('[data-cssvars="src"][data-cssvars-group="'.concat(t,'"]'))||e.parentNode.removeChild(e)}),R&&e.length<R&&(R=e.length,V.dom={}))}"loading"!==document.readyState?f&&S.onlyLegacy?(r=!1,S.updateDOM&&(n=S.rootElement.host||(S.rootElement===document?document.documentElement:S.rootElement),Object.keys(S.variables).forEach(function(e){var t=S.variables[e];r=r||t!==getComputedStyle(n).getPropertyValue(e),n.style.setProperty(e,t)})),C(r)):!y&&(S.shadowDOM||S.rootElement.shadowRoot||S.rootElement.host)?t({rootElement:d.rootElement,include:d.include,exclude:S.exclude,skipDisabled:!1,onSuccess:function(e,t,r){return!((t.sheet||{}).disabled&&!t.__cssVars)&&(((e=e.replace(M.cssComments,"").replace(M.cssMediaQueries,"")).match(M.cssVarDeclRules)||[]).join("")||!1)},onComplete:function(e,t,r){A(e,{store:V.dom,onWarning:w}),y=!0,T(S)}}):(L=S.rootElement,t({rootElement:S.rootElement,include:S.include,exclude:S.exclude,skipDisabled:!1,onBeforeSend:S.onBeforeSend,onError:function(e,t,r){var r=e.responseURL||g(r,location.href),n=e.statusText?"(".concat(e.statusText,")"):"Unspecified Error"+(0===e.status?" (possibly CORS related)":"");E("CSS XHR Error: ".concat(r," ").concat(e.status," ").concat(n),t,e,r)},onSuccess:function(e,t,r){var n,o,s,a;return!((t.sheet||{}).disabled&&!t.__cssVars)&&(n="link"===t.nodeName.toLowerCase(),o="style"===t.nodeName.toLowerCase()&&e!==t.textContent,t=S.onSuccess(e,t,r),e=void 0!==t&&!1===Boolean(t)?"":t||e,S.updateURLs&&(n||o)&&(a=r,((s=e).replace(M.cssComments,"").match(M.cssUrls)||[]).forEach(function(e){var t=e.replace(M.cssUrls,"$1"),r=g(t,a);s=s.replace(e,e.replace(t,r))}),e=s),e)},onComplete:function(e,u){var t=2<arguments.length&&void 0!==arguments[2]?arguments[2]:[],r=x({},V.dom,V.user);if(V.job={},t.forEach(function(e,t){var r=u[t];if(e.__cssVars=e.__cssVars||{},e.__cssVars.text=r,M.cssVars.test(r))try{var n=O(r,{preserveStatic:S.preserveStatic,removeComments:!0});A(n,{parseHost:Boolean(S.rootElement.host),store:V.dom,onWarning:w}),e.__cssVars.tree=n}catch(t){E(t.message,e)}}),x(V.job,V.dom),S.updateDOM?(x(V.user,S.variables),x(V.job,V.user)):(x(V.job,V.user,S.variables),x(r,S.variables)),0<j.job&&Boolean(Object.keys(V.job).length>Object.keys(r).length||Boolean(Object.keys(r).length&&Object.keys(V.job).some(function(e){return V.job[e]!==r[e]}))))N(S.rootElement),T(S);else{var l=[],f=[],d=!1;if(S.updateDOM&&j.job++,t.forEach(function(t,e){var r=!t.__cssVars.tree;if(t.__cssVars.tree)try{_(t.__cssVars.tree,x({},S,{variables:V.job,onWarning:w}));var n,o,s,a,c,i=k(t.__cssVars.tree);S.updateDOM?(n=u[e],o=M.cssVarFunc.test(n),t.getAttribute("data-cssvars")||t.setAttribute("data-cssvars","src"),i.length&&o&&(s=t.getAttribute("data-cssvars-group")||++j.group,a=i.replace(/\s/g,""),c=S.rootElement.querySelector('[data-cssvars="out"][data-cssvars-group="'.concat(s,'"]'))||document.createElement("style"),d=d||M.cssKeyframes.test(i),S.preserveStatic&&t.sheet&&(t.sheet.disabled=!0),c.hasAttribute("data-cssvars")||c.setAttribute("data-cssvars","out"),a===t.textContent.replace(/\s/g,"")?(r=!0,c&&c.parentNode&&(t.removeAttribute("data-cssvars-group"),c.parentNode.removeChild(c))):a!==c.textContent.replace(/\s/g,"")&&([t,c].forEach(function(e){e.setAttribute("data-cssvars-job",j.job),e.setAttribute("data-cssvars-group",s)}),c.textContent=i,l.push(i),f.push(c),c.parentNode||t.parentNode.insertBefore(c,t.nextSibling)))):t.textContent.replace(/\s/g,"")!==i&&l.push(i)}catch(e){E(e.message,t)}r&&t.setAttribute("data-cssvars","skip"),t.hasAttribute("data-cssvars-job")||t.setAttribute("data-cssvars-job",j.job)}),R=S.rootElement.querySelectorAll('[data-cssvars]:not([data-cssvars="out"])').length,S.shadowDOM)for(var n,o=[].concat(S.rootElement).concat([].slice.call(S.rootElement.querySelectorAll("*"))),s=0;n=o[s];++s)n.shadowRoot&&n.shadowRoot.querySelector("style")&&T(x({},S,{rootElement:n.shadowRoot}));if(S.updateDOM&&d){t=S.rootElement;var a=["animation-name","-moz-animation-name","-webkit-animation-name"].filter(function(e){return getComputedStyle(document.body)[e]})[0];if(a){for(var c=[].slice.call(t.querySelectorAll("*")),i=[],p="__CSSVARSPONYFILL-KEYFRAMES__",m=0,v=c.length;m<v;m++){var h=c[m];"none"!==getComputedStyle(h)[a]&&(h.style[a]+=p,i.push(h))}document.body.offsetHeight;for(var y=0,g=i.length;y<g;y++){var b=i[y].style;b[a]=b[a].replace(p,"")}}}L=!1,S.onComplete(l.join(""),f,JSON.parse(JSON.stringify(V.job)),D()-S.__benchmark),C(f.length)}}})):document.addEventListener("DOMContentLoaded",function e(t){T(o),document.removeEventListener("DOMContentLoaded",e)})}function i(e){var t=u(e)&&e.hasAttribute("disabled"),e=(e.sheet||{}).disabled;return t||e}function u(e){return"link"===e.nodeName.toLowerCase()&&-1!==(e.getAttribute("rel")||"").indexOf("stylesheet")}function l(e){return"style"===e.nodeName.toLowerCase()}}function g(e,t){var t=1<arguments.length&&void 0!==t?t:location.href,r=document.implementation.createHTMLDocument(""),n=r.createElement("base"),o=r.createElement("a");return r.head.appendChild(n),r.body.appendChild(o),n.href=t,o.href=e,o.href}function D(){return a&&(window.performance||{}).now?window.performance.now():(new Date).getTime()}function N(e,t){t=1<arguments.length&&void 0!==t&&t;[].slice.call(e.querySelectorAll('[data-cssvars="skip"],[data-cssvars="src"]')).forEach(function(e){return e.setAttribute("data-cssvars","")}),t&&(V.dom={})}return T.reset=function(){for(var e in j.job=0,j.group=0,L=!1,v&&(v.disconnect(),v=null),R=0,h=null,y=!1,V)V[e]={}},T});
//# sourceMappingURL=main.js.map