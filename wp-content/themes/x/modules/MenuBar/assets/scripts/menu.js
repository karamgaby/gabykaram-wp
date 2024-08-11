document.addEventListener('DOMContentLoaded', function () {
  // Your code here

  const menuItems = document.querySelectorAll('.x-header-drawer-link-js');
  menuItems.forEach((item) => {
    item.addEventListener('click', (e) => {
      const offCanvasElement = e.target.closest('.offcanvas-js');
      const offCanvas = bootstrap.Offcanvas.getInstance(offCanvasElement);
      offCanvas.hide();
    })
  })
  const offcanvasElementList = document.querySelectorAll('.offcanvas-js')
  const offcanvasList = [...offcanvasElementList].map(offcanvasEl => {
    let bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl);
    if (!bsOffcanvas) {
      bsOffcanvas = new bootstrap.Offcanvas(offcanvasEl);
    }
    offcanvasEl.addEventListener('shown.bs.offcanvas', event => {
      const backdrop = document.querySelector('.offcanvas-backdrop');
      document.body.classList.add('x-menu-bar-enable-sticky-header');
      document.body.classList.add('x-header-drawer-visible');
      if (backdrop) {
        backdrop.classList.add('x-header-drawer-visible');
      }
    })
    offcanvasEl.addEventListener('hidden.bs.offcanvas', event => {
      document.body.classList.remove('x-header-drawer-visible');
    })
    return offcanvasEl;
  })

  const menuBarMobile__toggle = document.querySelector('.menuBarMobile__toggle');
  menuBarMobile__toggle.addEventListener('click', (e) => {
    e.preventDefault();
    const menuBarMobile__toggle = e.target.closest('.menuBarMobile__toggle');
    const dataTarget = menuBarMobile__toggle.getAttribute('data-bs-target');
    const offcanvas = document.querySelector(dataTarget);
    let bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvas);
    if (!bsOffcanvas) {
      bsOffcanvas = new bootstrap.Offcanvas(offcanvas);
    }
    bsOffcanvas.toggle();
  });

  function fixHeaderScrollBehavior() {
    const scroll = document.documentElement.scrollTop || document.body.scrollTop;
    const windowWidth = window.innerWidth;
    const previousScroll = window.previousScroll;
    window.previousScroll = scroll;
    const isScrollingDown = previousScroll * 100 < scroll * 100;
    const headerHeight = document.querySelector('.x-menuBar').offsetHeight;
    const headerVisibleRange = headerHeight * 4;
    document.body.style.setProperty('--x-header-height', `${headerHeight}px`);
    document.body.style.setProperty('--x-window-width', `${windowWidth}px`);
    if(document.body.classList.contains('x-header-drawer-visible')) {
      document.body.classList.add('x-menu-bar-enable-sticky-header');
    } else {
      if (scroll < headerHeight) {
        document.body.classList.add('x-menu-bar-enable-sticky-header');
      }
      if(isScrollingDown) {
        document.body.classList.remove('x-menu-bar-enable-sticky-header');
        if(scroll > headerVisibleRange) {
          document.body.classList.add('x-menu-bar-slide-up');
          document.body.classList.remove('x-menu-bar-slide-down');
        }
      } else {
        if(scroll > headerVisibleRange) {
          document.body.classList.add('x-menu-bar-enable-sticky-header');
          document.body.classList.add('x-menu-bar-slide-down');
          document.body.classList.remove('x-menu-bar-slide-up');
        } else if(scroll > headerHeight) {
          document.body.classList.remove('x-menu-bar-enable-sticky-header');
          document.body.classList.remove('x-menu-bar-slide-down');
          document.body.classList.add('x-menu-bar-slide-up');
        } else {
          document.body.classList.remove('x-menu-bar-enable-sticky-header');
          document.body.classList.remove('x-menu-bar-slide-down');
          document.body.classList.remove('x-menu-bar-slide-up');
        }
      }
    }
    const body = document.querySelector('body');
    body.classList.remove('js-not-loaded')
  }
  window.addEventListener('resize', function () {
    fixHeaderScrollBehavior();
  });

  window.addEventListener('scroll', function () {
    fixHeaderScrollBehavior();
  });

  document.addEventListener('click', function (event) {
    const isClickInside = event.target.closest('.x-header-drawer, .x-menuBar');
    if (!isClickInside) {
      // If the click is outside of the x-header-drawer or x-menuBar, close the offcanvas
      const offcanvas = document.querySelector('.offcanvas');
      if (offcanvas) {
        const bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvas);
        if (bsOffcanvas) {
          bsOffcanvas.hide();
        }
      }
    }
  });
});
