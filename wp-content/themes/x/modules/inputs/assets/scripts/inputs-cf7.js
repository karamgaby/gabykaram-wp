(function () {
  const urlInputHelper = form => {
    form.querySelectorAll('.x_inputs-wpcf7-validates-as-url').forEach(element => {
      element.addEventListener('change', event => {
        let val = element.value.trim();

        if (val && !val.match(/^[a-z][a-z0-9.+-]*:/i)
          && -1 !== val.indexOf('.')) {
          val = val.replace(/^\/+/, '');
          val = 'https://' + val;
        }

        element.value = val;
      });
    });
  };

  const clearResponse = form => {
    form.querySelectorAll('.x_inputs-wpcf7-form-control-wrap').forEach(wrap => {
      if (wrap.dataset.name) {
        removeValidationError(form, wrap.dataset.name);
      }
    });

  };

  const triggerEvent = (target, name, detail) => {
    const event = new CustomEvent(`wpcf7${name}`, {
      bubbles: true,
      detail,
    });

    if (typeof target === 'string') {
      target = document.querySelector(target);
    }

    target.dispatchEvent(event);
  };

  const setStatus = (form, status) => {
    const defaultStatuses = new Map([
      // 0: Status in API response, 1: Status in HTML class
      ['init', 'init'],
      ['validation_failed', 'invalid'],
      ['acceptance_missing', 'unaccepted'],
      ['spam', 'spam'],
      ['aborted', 'aborted'],
      ['mail_sent', 'sent'],
      ['mail_failed', 'failed'],
      ['submitting', 'submitting'],
      ['resetting', 'resetting'],
      ['validating', 'validating'],
      ['payment_required', 'payment-required'],
    ]);

    if (defaultStatuses.has(status)) {
      status = defaultStatuses.get(status);
    }

    if (!Array.from(defaultStatuses.values()).includes(status)) {
      status = status.replace(/[^0-9a-z]+/i, ' ').trim();
      status = status.replace(/\s+/, '-');
      status = `custom-${status}`;
    }

    const prevStatus = form.getAttribute('data-status');

    form.wpcf7.status = status;
    form.setAttribute('data-status', status);
    form.classList.add(status);

    if (prevStatus && prevStatus !== status) {
      form.classList.remove(prevStatus);

      const detail = {
        contactFormId: form.wpcf7.id,
        pluginVersion: form.wpcf7.pluginVersion,
        contactFormLocale: form.wpcf7.locale,
        unitTag: form.wpcf7.unitTag,
        containerPostId: form.wpcf7.containerPost,
        status: form.wpcf7.status,
        prevStatus,
      };

      triggerEvent(form, 'statuschanged', detail);
    }

    return status;
  };


  function validate(form, options = {}) {
    const {
      target,
      scope = form,
      ...remainingOptions
    } = options;

    if (undefined === form.wpcf7?.schema) {
      return;
    }

    const schema = {...form.wpcf7.schema};

    if (undefined !== target) {
      if (!form.contains(target)) {
        return;
      }

      // Event target is not a wpcf7 form control.
      if (!target.closest('.x_inputs-wpcf7-form-control-wrap[data-name]')) {
        return;
      }

      if (target.closest('.novalidate')) {
        return;
      }
    }

    const wrapList = scope.querySelectorAll('.x_inputs-wpcf7-form-control-wrap');

    const formData = Array.from(wrapList).reduce((formData, wrap) => {
      if (wrap.closest('.novalidate')) {
        return formData;
      }

      wrap.querySelectorAll(
        ':where( input, textarea, select ):enabled'
      ).forEach(control => {
        if (!control.name) {
          return;
        }

        switch (control.type) {
          case 'button':
          case 'image':
          case 'reset':
          case 'submit':
          case 'file':
          case 'checkbox':
          case 'radio':
          case 'select-multiple':
            break;
          default:
            formData.append(control.name, control.value);
        }
      });

      return formData;
    }, new FormData());

    const prevStatus = form.getAttribute('data-status');

    Promise.resolve(setStatus(form, 'validating'))
      .then(status => {
        if (undefined !== swv) {
          const result = swv.validate(schema, formData, options);

          for (const wrap of wrapList) {
            if (undefined === wrap.dataset.name) {
              continue;
            }

            const field = wrap.dataset.name;

            if (result.has(field)) {
              const {error, validInputs} = result.get(field);

              removeValidationError(form, field);
              if (undefined !== error) {
                setValidationError(form, field, error, {scope});
              }

              updateReflection(form, field, validInputs ?? []);
            }

            if (wrap.contains(target)) {
              break;
            }
          }
        }
      })
      .finally(() => {
        setStatus(form, prevStatus);
      });
  }

  const setValidationError = (form, fieldName, message, options) => {
    const {
      scope = form,
      ...remainingOptions
    } = options ?? {};
    debugger
    const errorId = `${form.wpcf7?.unitTag}-ve-${fieldName}`
      .replaceAll(/[^0-9a-z_-]+/ig, '');

    const firstFoundControl = form.querySelector(
      `.x_inputs-wpcf7-form-control-wrap[data-name="${fieldName}"] .x_inputs-wpcf7-form-control`
    );

    const setScreenReaderValidationError = () => {
      const li = document.createElement('li');

      li.setAttribute('id', errorId);

      if (firstFoundControl && firstFoundControl.id) {
        li.insertAdjacentHTML(
          'beforeend',
          `<a href="#${firstFoundControl.id}">${message}</a>`
        );
      } else {
        li.insertAdjacentText(
          'beforeend',
          message
        );
      }

      form.wpcf7.parent.querySelector(
        '.screen-reader-response ul'
      ).appendChild(li);
    };

    const setVisualValidationError = () => {
      scope.querySelectorAll(
        `.x_inputs-wpcf7-form-control-wrap[data-name="${fieldName}"]`
      ).forEach(wrap => {
        // @todo add magic
        wrap.classList.add('ps-input-status-error');
        let messageElement = wrap.querySelector('.ps-input-message');

        if (!messageElement) {
          messageElement = document.createElement('span')
        }
        ;
        messageElement.setAttribute('aria-hidden', 'true');
        messageElement.innerHTML = message;

        wrap.querySelectorAll('[aria-invalid]').forEach(elm => {
          elm.setAttribute('aria-invalid', 'true');
        });

        wrap.querySelectorAll('.x_inputs-wpcf7-form-control').forEach(control => {
          control.classList.add('wpcf7-not-valid');
          control.setAttribute('aria-describedby', errorId);
          if (typeof control.setCustomValidity === 'function') {
            control.setCustomValidity(message);
          }
        });
      });
    };

    setScreenReaderValidationError();
    setVisualValidationError();
  };

  const removeValidationError = (form, fieldName) => {
    debugger;
    const errorId = `${form.wpcf7?.unitTag}-ve-${fieldName}`
      .replaceAll(/[^0-9a-z_-]+/ig, '');

    form.wpcf7.parent.querySelector(
      `.screen-reader-response ul li#${errorId}`
    )?.remove();

    form.querySelectorAll(
      `.x_inputs-wpcf7-form-control-wrap[data-name="${fieldName}"]`
    ).forEach(wrap => {
      wrap.classList.remove('ps-input-status-error');
      let messageElement = wrap.querySelector('.ps-input-message');
      messageElement.innerHTML = '';
      wrap.querySelectorAll('[aria-invalid]').forEach(elm => {
        elm.setAttribute('aria-invalid', 'false');
      });

      wrap.querySelectorAll('.x_inputs-wpcf7-form-control').forEach(control => {
        control.removeAttribute('aria-describedby');
        control.classList.remove('wpcf7-not-valid');

        if (typeof control.setCustomValidity === 'function') {
          control.setCustomValidity('');
        }
      });
    });
  };

  const updateReflection = (form, field, validInputs) => {
    form.querySelectorAll(
      `[data-reflection-of="${field}"]`
    ).forEach(reflection => {
      if ('output' === reflection.tagName.toLowerCase()) {
        const output = reflection;

        if (0 === validInputs.length) {
          validInputs.push(output.dataset.default);
        }

        validInputs.slice(0, 1).forEach(input => {
          if (input instanceof File) {
            input = input.name;
          }

          output.textContent = input;
        });

      } else {
        reflection.querySelectorAll(
          'output'
        ).forEach(output => {
          if (output.hasAttribute('data-default')) {
            if (0 === validInputs.length) {
              output.removeAttribute('hidden');
            } else {
              output.setAttribute('hidden', 'hidden');
            }
          } else {
            output.remove();
          }
        });

        validInputs.forEach(input => {

          if (input instanceof File) {
            input = input.name;
          }

          const output = document.createElement('output');

          output.setAttribute('name', field);
          output.textContent = input;

          reflection.appendChild(output);
        });
      }
    });
  };


  document.addEventListener('DOMContentLoaded', (event) => {
    // Your code here
    document.querySelectorAll('.wpcf7-form').forEach(form => {
      urlInputHelper(form);
      form.addEventListener('wpcf7submit', (event) => {
        const status = event.detail.status;
        const response = event.detail.apiResponse;
        if (response?.invalid_fields) {
          response.invalid_fields.forEach(error => {
            setValidationError(form, error.field, error.message);
          })
        }
      });


      form.addEventListener('wpcf7submitting', function (event) {
        if (wpcf7.blocked) {
          clearResponse(form);
          return;
        }
      })
      form.addEventListener('wpcf7beforesubmit', (event) => {
        const status = event.detail.status;
        clearResponse(form);
      });

      form.addEventListener('change', event => {
        if (event.target.closest('.x_inputs-wpcf7-form-control')) {
          validate(form, {target: event.target});
        }
      });

      form.addEventListener('wpcf7statuschanged', (event) => {
        const status = event.detail.status;
        const formElement = event.target;
        if (status === 'resetting') {
          clearResponse(form);
        }
      })
    });
  });


})();
