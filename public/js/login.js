(() => {
  'use strict';

  const root = document.querySelector('.cl-login03');
  if (!root) return;
  const form = root.querySelector('[data-form]');
  if (!form) return;

  const messageFor = (el) => {
    const val = el.value.trim();
    if (el.required && !val) {
      return el.dataset.msg || 'Preencha este campo.';
    }
    return '';
  };

  const check = (field) => {
    const el = field.querySelector('input');
    if (!el) return true;
    const msg = messageFor(el);
    const errEl = field.querySelector('[data-error]');
    if (errEl) errEl.textContent = msg;
    field.classList.toggle('is-error', !!msg);
    if (msg) {
      el.setAttribute('aria-invalid', 'true');
    } else {
      el.removeAttribute('aria-invalid');
    }
    return !msg;
  };

  const fields = Array.from(form.querySelectorAll('[data-field]'));
  fields.forEach((field) => {
    const input = field.querySelector('input');
    if (!input) return;
    field.addEventListener('focusout', (e) => {
      if (field.contains(e.relatedTarget) || (e.relatedTarget && e.relatedTarget.matches('button')) || !input.value) return;
      field.dataset.touched = '1';
      check(field);
    });
    field.addEventListener('input', () => {
      if (field.dataset.touched) check(field);
    });
  });

  // Password visibility toggle
  root.querySelectorAll('[data-pw-toggle]').forEach((btn) => {
    const targetId = btn.getAttribute('aria-controls');
    const input = document.getElementById(targetId);
    if (!input) return;
    btn.addEventListener('click', () => {
      const show = input.type === 'password';
      input.type = show ? 'text' : 'password';
      btn.setAttribute('aria-pressed', String(show));
      btn.setAttribute('aria-label', show ? 'Ocultar senha' : 'Exibir senha');
    });
  });

  // Form submit validation: if invalid, prevent submit and highlight; if valid, submit form
  form.addEventListener('submit', (e) => {
    let hasError = false;
    let firstBadInput = null;

    fields.forEach((f) => {
      f.dataset.touched = '1';
      if (!check(f)) {
        hasError = true;
        if (!firstBadInput) firstBadInput = f.querySelector('input');
      }
    });

    if (hasError) {
      e.preventDefault();
      if (firstBadInput) firstBadInput.focus();
    }
  });
})();
