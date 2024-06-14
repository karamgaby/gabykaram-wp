/* ==========================================================================
  main.js
========================================================================== */

'use strict';
/* global fitvids, cssVars */

/**
 * Init responsive videos
 */
fitvids();

/**
 * Init CSS vars ponyfill
 */
cssVars({});
function remToPx(rem) {
  // Get the root element (HTML)
  const rootElement = document.documentElement;

  // Get the computed font size of the root element in pixels
  const fontSize = window.getComputedStyle(rootElement).fontSize;

  // Parse the font size to a number
  const fontSizeInPx = parseFloat(fontSize);

  // Multiply the rem value by the font size in pixels
  return rem * fontSizeInPx;
}
document.addEventListener('DOMContentLoaded', (event) => {
  const swiper = new Swiper(".pictures-slides", {
    slidesPerView: 'auto',
    spaceBetween: remToPx(1),
    freeMode: true,
  });

  window.addEventListener('resize', function () {
    swiper.params.spaceBetween = remToPx(1);
    swiper.update();
  });
  // $.fancybox.defaults.hideScrollbar = false;
  Fancybox.bind('[data-fancybox]', {
    height: () => Math.max(window.innerHeight * 0.5, 320),
    Images: {
      zoom: false,
    },
    backFocus: false,
    hideScrollbar: false,
    Hash: false,
  });   
});
