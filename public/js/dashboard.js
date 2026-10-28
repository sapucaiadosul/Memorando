(() => {
  'use strict';

  // Toggle systems sidebar menu (equivalent to legado's abrirMenuApp)
  const appBtn = document.getElementById('btn-app-menu');
  const sidebar = document.getElementById('menu-grupos');
  const backdrop = document.getElementById('sidebar-backdrop');
  const closeBtn = document.getElementById('sidebar-close');

  const toggleSidebar = (forceState) => {
    if (!sidebar || !backdrop) return;
    const shouldOpen = typeof forceState === 'boolean' 
      ? forceState 
      : !sidebar.classList.contains('is-open');

    sidebar.classList.toggle('is-open', shouldOpen);
    backdrop.classList.toggle('is-open', shouldOpen);
    document.body.style.overflow = shouldOpen ? 'hidden' : '';
  };

  window.abrirMenuApp = () => toggleSidebar();

  if (appBtn) {
    appBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      toggleSidebar();
    });
  }

  if (closeBtn) {
    closeBtn.addEventListener('click', () => toggleSidebar(false));
  }

  if (backdrop) {
    backdrop.addEventListener('click', () => toggleSidebar(false));
  }

  // Keyboard shortcut: Escape closes sidebar and dropdowns
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      toggleSidebar(false);
      closeAllDropdowns();
    }
  });

  // Dropdown management
  const dropdowns = document.querySelectorAll('.cl-dropdown');
  const closeAllDropdowns = () => {
    dropdowns.forEach((dd) => dd.classList.remove('is-open'));
  };

  dropdowns.forEach((dd) => {
    const trigger = dd.querySelector('[data-dropdown-toggle]');
    if (!trigger) return;

    trigger.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      const isOpen = dd.classList.contains('is-open');
      closeAllDropdowns();
      if (!isOpen) dd.classList.add('is-open');
    });
  });

  document.addEventListener('click', (e) => {
    if (!e.target.closest('.cl-dropdown')) {
      closeAllDropdowns();
    }
  });

  // Alert banner close functionality
  document.querySelectorAll('[data-alert-dismiss]').forEach((btn) => {
    btn.addEventListener('click', () => {
      const banner = btn.closest('.cl-alert-banner');
      if (banner) {
        banner.style.opacity = '0';
        banner.style.transform = 'translateY(-10px)';
        banner.style.transition = 'all 0.2s ease';
        setTimeout(() => banner.remove(), 200);
      }
    });
  });

  // Password visibility toggle
  document.querySelectorAll('[data-pw-toggle]').forEach((btn) => {
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
})();
