<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Memorando - SiGeM')</title>
  <link rel="icon" href="{{ asset('favicon.ico') }}">
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body class="cl-dashboard">
  <div class="cl-dashboard__glow" aria-hidden="true"></div>

  <!-- Top Navbar -->
  <header class="cl-navbar" id="menu-modulos" role="navigation">
    <div class="cl-navbar__left">
      <button
        type="button"
        class="cl-app-btn"
        id="btn-app-menu"
        onclick="abrirMenuApp()"
        title="Sistemas"
        aria-label="Abrir menu de sistemas"
        aria-expanded="false"
        aria-controls="menu-grupos">
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
          <circle cx="5" cy="5" r="2" />
          <circle cx="12" cy="5" r="2" />
          <circle cx="19" cy="5" r="2" />
          <circle cx="5" cy="12" r="2" />
          <circle cx="12" cy="12" r="2" />
          <circle cx="19" cy="12" r="2" />
          <circle cx="5" cy="19" r="2" />
          <circle cx="12" cy="19" r="2" />
          <circle cx="19" cy="19" r="2" />
        </svg>
      </button>

      <a class="cl-navbar__brand" href="{{ route('home') }}" aria-label="Memorando Início">
        <img class="cl-navbar__logo" src="{{ asset('img/pmsps.png') }}" alt="Prefeitura Municipal" width="90" height="34">
        <span class="cl-navbar__title">Memorando</span>
        <span class="cl-navbar__badge">SiGeM</span>
      </a>
    </div>

    <nav class="cl-navbar__right" aria-label="Menu de navegação superior">
      @can('manage-users')
        <a class="cl-nav-link {{ request()->routeIs('users.*') ? 'is-active' : '' }}" href="{{ route('users.index') }}" title="Usuários">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
            <circle cx="9" cy="7" r="4" />
            <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
          </svg>
          <span>Usuários</span>
        </a>
      @endcan

      <a class="cl-nav-link {{ request()->routeIs('password.change') ? 'is-active' : '' }}" href="{{ route('password.change') }}" title="Trocar senha">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
          <path d="M7 11V7a5 5 0 0 1 10 0v4" />
        </svg>
        <span>Trocar senha</span>
      </a>

      <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
        @csrf
        <button class="cl-nav-logout" type="submit" title="Sair do sistema">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
            <polyline points="16 17 21 12 16 7" />
            <line x1="21" y1="12" x2="9" y2="12" />
          </svg>
          <span>Sair</span>
        </button>
      </form>
    </nav>
  </header>

  <!-- Sidebar Drawer -->
  <div class="cl-sidebar-backdrop" id="sidebar-backdrop" aria-hidden="true"></div>

  <aside class="cl-sidebar" id="menu-grupos" aria-label="Menu de Sistemas">
    <div class="cl-sidebar__header">
      <h2 class="cl-sidebar__heading">
        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" style="color: var(--dash-violet);">
          <circle cx="5" cy="5" r="2" />
          <circle cx="12" cy="5" r="2" />
          <circle cx="19" cy="5" r="2" />
          <circle cx="5" cy="12" r="2" />
          <circle cx="12" cy="12" r="2" />
          <circle cx="19" cy="12" r="2" />
          <circle cx="5" cy="19" r="2" />
          <circle cx="12" cy="19" r="2" />
          <circle cx="19" cy="19" r="2" />
        </svg>
        <span>Sistemas</span>
      </h2>
      <button type="button" class="cl-sidebar__close" id="sidebar-close" aria-label="Fechar menu" title="Fechar menu">
        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
          <line x1="18" y1="6" x2="6" y2="18" />
          <line x1="6" y1="6" x2="18" y2="18" />
        </svg>
      </button>
    </div>

    <div class="cl-sidebar__content">
      <div class="cl-sidebar__section-title">Grupos de Módulos</div>
      <ul class="cl-sidebar__nav">
        <li>
          <a class="cl-sidebar__item {{ request()->routeIs('home') ? 'is-active' : '' }}" href="{{ route('home') }}" title="Sistema Memorando">
            <div class="cl-sidebar__item-left">
              <svg class="cl-sidebar__item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                <polyline points="14 2 14 8 20 8" />
                <line x1="16" y1="13" x2="8" y2="13" />
                <line x1="16" y1="17" x2="8" y2="17" />
                <polyline points="10 9 9 9 8 9" />
              </svg>
              <span>Memorando</span>
            </div>
          </a>
        </li>
        @can('manage-users')
          <li>
            <a class="cl-sidebar__item {{ request()->routeIs('users.*') ? 'is-active' : '' }}" href="{{ route('users.index') }}" title="Gerenciamento de Usuários">
              <div class="cl-sidebar__item-left">
                <svg class="cl-sidebar__item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                  <circle cx="9" cy="7" r="4" />
                  <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                  <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
                <span>Usuários</span>
              </div>
              @if (request()->routeIs('users.*'))
                <span class="cl-sidebar__badge">Ativo</span>
              @endif
            </a>
          </li>
        @endcan
      </ul>
    </div>

    <div class="cl-sidebar__footer">
      <div class="cl-sidebar__user">
        <div class="cl-sidebar__avatar">
          {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
        </div>
        <div class="cl-sidebar__user-info">
          <p class="cl-sidebar__user-name">{{ Auth::user()->name ?? 'Usuário Autenticado' }}</p>
          <p class="cl-sidebar__user-status">Sessão Conectada</p>
        </div>
      </div>
    </div>
  </aside>

  <!-- Main Content -->
  <main class="cl-main">
    @yield('content')

    <footer class="cl-footer-info">
      <div>
        <span>Prefeitura Municipal de Sapucaia do Sul - RS &middot; SIGEM - Memorando</span>
      </div>
      <div>
        <span>Suporte de TI (WhatsApp) &middot; 51 3451 8065</span>
      </div>
    </footer>
  </main>

  <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>
