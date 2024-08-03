(function () {

  const checkAcceptance = (form) => {
    let accepted = true;

    form.querySelectorAll('.wpcf7-acceptance').forEach(parent => {
      if (!accepted || parent.classList.contains('optional')) {
        return;
      }

      const checkbox = parent.querySelector('input[type="checkbox"]');

      if (parent.classList.contains('invert') && checkbox.checked || !parent.classList.contains('invert') && !checkbox.checked) {
        accepted = false;
      }
    });

    form.querySelectorAll('.wpcf7-x_submit').forEach(button => {
      button.disabled = !accepted;
    });
  };


  document.addEventListener('DOMContentLoaded', (event) => {
    document.querySelectorAll('.wpcf7-form').forEach(form => {
      checkAcceptance(form);

      form.addEventListener('change', event => {
        checkAcceptance(form);
      });

      form.addEventListener('wpcf7reset', event => {
        checkAcceptance(form);
      });
    });
  });

})();
