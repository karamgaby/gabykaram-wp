(()=>{var e={63166:(e,t,r)=>{"use strict";r.d(t,{fc:()=>i});let o="";function n(e){if("https://subscribe.wordpress.com"===e.origin&&e.data){const t=JSON.parse(e.data);if(t&&t.result&&t.result.jwt_token&&(o=t.result.jwt_token,c(o)),t&&"close"===t.action&&o)window.location.reload(!0);else if(t&&"close"===t.action){window.removeEventListener("message",n);document.getElementById("memberships-modal-window").close(),document.body.classList.remove("jetpack-memberships-modal-open")}}}function s(e){e.insertAdjacentHTML("beforeend",'<span class="jetpack-memberships-spinner">\t<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">\t\t<path d="M12,1A11,11,0,1,0,23,12,11,11,0,0,0,12,1Zm0,19a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z" opacity=".25" fill="currentColor" />\t\t<path d="M10.14,1.16a11,11,0,0,0-9,8.92A1.59,1.59,0,0,0,2.46,12,1.52,1.52,0,0,0,4.11,10.7a8,8,0,0,1,6.66-6.61A1.42,1.42,0,0,0,12,2.69h0A1.57,1.57,0,0,0,10.14,1.16Z" class="jetpack-memberships-spinner-rotating" fill="currentColor" />\t</svg></span>'),e.addEventListener("click",(t=>{t.preventDefault(),e.classList.add("is-loading"),e.setAttribute("aria-busy","true"),e.setAttribute("aria-live","polite");return function(e){return new Promise((t=>{const r=document.getElementById("memberships-modal-window");r&&document.body.removeChild(r);const o=document.createElement("dialog");o.setAttribute("id","memberships-modal-window"),o.classList.add("jetpack-memberships-modal"),o.classList.add("is-loading");const s=document.createElement("iframe");s.setAttribute("frameborder","0"),s.setAttribute("allowtransparency","true"),s.setAttribute("allowfullscreen","true"),s.addEventListener("load",(function(){document.body.classList.add("jetpack-memberships-modal-open"),o.classList.remove("is-loading"),t()})),s.setAttribute("id","memberships-modal-iframe"),s.innerText="This feature requires inline frames. You have iframes disabled or your browser does not support them.",s.src=e+"&display=alternate&jwt_token="+a();const i=document.querySelector('input[name="lang"]')?.value;i&&(s.src=s.src+"&lang="+i),document.body.appendChild(o),o.appendChild(s),window.addEventListener("message",n,!1),o.showModal()}))}(e.getAttribute("href")).then((()=>{e.classList.remove("is-loading"),e.setAttribute("aria-busy","false")})),e.blur(),!1}))}const i=e=>{Array.prototype.slice.call(document.querySelectorAll(e)).forEach((e=>{if("true"!==e.getAttribute("data-jetpack-memberships-button-initialized")){try{s(e)}catch(e){console.error("Problem setting up Modal",e)}e.setAttribute("data-jetpack-memberships-button-initialized","true")}}))},a=function(){const e=`; ${document.cookie}`.split("; wp-jp-premium-content-session=");if(2===e.length)return e.pop().split(";").shift()},c=function(e){const t=new Date,r=new Date(t.setMonth(t.getMonth()+1));document.cookie=`wp-jp-premium-content-session=${e}; expires=${r.toGMTString()}; path=/`}},80425:(e,t,r)=>{"object"==typeof window&&window.Jetpack_Block_Assets_Base_Url&&(r.p=window.Jetpack_Block_Assets_Base_Url)},47701:e=>{"use strict";e.exports=window.wp.domReady}},t={};function r(o){var n=t[o];if(void 0!==n)return n.exports;var s=t[o]={exports:{}};return e[o](s,s.exports,r),s.exports}r.n=e=>{var t=e&&e.__esModule?()=>e.default:()=>e;return r.d(t,{a:t}),t},r.d=(e,t)=>{for(var o in t)r.o(t,o)&&!r.o(e,o)&&Object.defineProperty(e,o,{enumerable:!0,get:t[o]})},r.g=function(){if("object"==typeof globalThis)return globalThis;try{return this||new Function("return this")()}catch(e){if("object"==typeof window)return window}}(),r.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),(()=>{var e;r.g.importScripts&&(e=r.g.location+"");var t=r.g.document;if(!e&&t&&(t.currentScript&&(e=t.currentScript.src),!e)){var o=t.getElementsByTagName("script");o.length&&(e=o[o.length-1].src)}if(!e)throw new Error("Automatic publicPath is not supported in this browser");e=e.replace(/#.*$/,"").replace(/\?.*$/,"").replace(/\/[^\/]+$/,"/"),r.p=e+"../"})(),(()=>{"use strict";r(80425)})(),(()=>{"use strict";var e=r(47701),t=r.n(e),o=r(63166);const n=[{querySelector:".wp-block-premium-content-container",blockType:"paid-content"},{querySelector:".wp-block-jetpack-payment-buttons",blockType:"payment-button"},{querySelector:".jetpack-subscribe-paywall",blockType:"paywall"},{querySelector:".wp-block-jetpack-donations",blockType:"donations"}];"undefined"!=typeof window&&t()((()=>{(0,o.fc)(".wp-block-jetpack-recurring-payments a"),setTimeout((()=>{const e=new URL(window.location.href);if(document.querySelectorAll(".wp-block-button__link").forEach((e=>{if(e.href){const t=new URL(e.href),r=n.filter((t=>e.closest(t.querySelector)?.contains(e)));1===r.length&&(t.searchParams.set("block_type",r[0].blockType),e.href=t.toString())}})),e.searchParams.has("recurring_payments")&&window.history.replaceState){const t=`recurring-payments-${e.searchParams.get("recurring_payments")}`;e.searchParams.delete("recurring_payments"),window.history.replaceState({},"",e),document.getElementById(t)?.click()}}),100)}))})()})();