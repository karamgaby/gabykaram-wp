document.addEventListener('DOMContentLoaded', function() {
  // Your code here

  const menuItems = document.querySelectorAll('.x-header-drawer-link-js');
  menuItems.forEach((item) => {
    item.addEventListener('click', (e) => {
      const offCanvasElement = e.target.closest('.offcanvas-js');
      const offCanvas =  bootstrap.Offcanvas.getInstance(offCanvasElement);
      offCanvas.hide();
    })
  })
  const offcanvasElementList = document.querySelectorAll('.offcanvas-js')
  const offcanvasList = [...offcanvasElementList].map(offcanvasEl => {
    const offCanvas =  new bootstrap.Offcanvas(offcanvasEl);
    offcanvasEl.addEventListener('shown.bs.offcanvas', event => {
      const backdrop = document.querySelector('.offcanvas-backdrop');
      if (backdrop) {
        backdrop.classList.add('x-header-drawer-visible');
      }
    })

    return offCanvas;
  })

  console.log(offcanvasList)

});
