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

  setupPicturesSlider();
  setupGalleryFancyBox();
  setupIconsSlider();
  setupWordsSlider();
  handleBackToBlogsButton();
  const modals = document.querySelectorAll('.youtube-card-modal');

  modals.forEach(modal => {
    modal.addEventListener('hide.bs.modal', function () {
      modal.querySelectorAll('iframe').forEach(iframe => {
        iframe.src = '';
      });
    });

    modal.addEventListener('show.bs.modal', function () {
      modal.querySelectorAll('iframe').forEach(iframe => {
        iframe.src = iframe.getAttribute('data-src');
      });
    });
  });
  function setupIconsSlider() {
    if (document.querySelectorAll('.icons-slides').length > 0) {
      const swiper = new Swiper(".icons-slides", {
        slidesPerView: 'auto',
        spaceBetween: remToPx(1.5),
        freeMode: true,
        centerInsufficientSlides: true,
        grabCursor: true,
        loop: true,
        longSwipes: false,
      });
      window.addEventListener('resize', function () {
        swiper.params.spaceBetween = remToPx(1.5);
        swiper.updateAutoHeight(300);
        swiper.update();
      });
    }
  }
  function setupWordsSlider() {
    if (document.querySelectorAll('.sliding-words-slider').length > 0) {
      // @todo replace with bxskuder Better transition https://bxslider.com/options
      const swiper = new Swiper(".sliding-words-slider", {
        slidesPerView: 'auto',
        spaceBetween: remToPx(1.5),
        freeMode: true,
        loop: true,
        speed: 2000,
        autoplay: {
          delay: 0.1,
          // delay: 1200,
          disableOnInteraction: false,
          waitForTransition: false,

        },
      });
      window.addEventListener('resize', function () {
        swiper.params.spaceBetween = remToPx(1.5);
        swiper.update();
      });
    }
  }
  function setupPicturesSlider() {
    if (document.querySelectorAll('.pictures-slides').length > 0) {
      const swiper = new Swiper(".pictures-slides", {
        slidesPerView: 'auto',
        spaceBetween: remToPx(1),
        freeMode: true,
        grabCursor: true,
        loop: true,
        longSwipes: false,
      });

      window.addEventListener('resize', function () {
        swiper.params.spaceBetween = remToPx(1);
        swiper.update();
      });
    }
  }

  function setupGalleryFancyBox() {
    Fancybox.bind('[data-fancybox]', {
      height: () => Math.max(window.innerHeight * 0.5, 320),
      Images: {
        zoom: false,
      },
      backFocus: false,
      hideScrollbar: false,
      Hash: false,
    });
  }
  function handleBackToBlogsButton() {
    const blog_page_url = x_theme_script_vars.blog_page_url;
    const site_domain = x_theme_script_vars.site_domain;

    document.querySelectorAll('.back-to-blogs-page').forEach(button => {
      button.addEventListener('click', function () {
        const referrerDomain = document.referrer.split('/')[2];
        if (referrerDomain === site_domain && document.referrer.split('/')[3] !== undefined && document.referrer.split('/')[3] === blog_page_url.split('/')[3]) {
          window.history.back();
        } else {
          window.location.href = blog_page_url;
        }
      });
    });
  }
});
