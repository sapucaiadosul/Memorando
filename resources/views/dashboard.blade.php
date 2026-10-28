<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Memorando - Início</title>
  <link rel="icon" href="{{ asset('favicon.ico') }}">
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body class="cl-dashboard">
  <div class="cl-dashboard__glow" aria-hidden="true"></div>

  <!-- ========================================================================
       1. Top Navbar (menu_modulos do legado)
       ======================================================================== -->
  <header class="cl-navbar" id="menu-modulos" role="navigation">
    <div class="cl-navbar__left">
      <!-- Brand / Logotipo do sistema -->
      <a class="cl-navbar__brand" href="{{ url('/') }}" aria-label="Memorando Início">
        <img class="cl-navbar__logo" src="{{ asset('img/pmsps.png') }}" alt="Prefeitura Municipal" width="90" height="34">
        <span class="cl-navbar__title">Memorando</span>
        <span class="cl-navbar__badge">SiGeM</span>
      </a>
    </div>

    <nav class="cl-navbar__right" aria-label="Menu de navegação superior">
      <!-- Links da barra  -->
      <a class="cl-nav-link" href="{{ route('password.change') }}" title="Trocar senha">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
          <path d="M7 11V7a5 5 0 0 1 10 0v4" />
        </svg>
        <span>Trocar senha</span>
      </a>

      <!-- Sair (Logout via POST) -->
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

  <!-- ========================================================================
       2. Sidebar Drawer (menu_grupos do legado)
       ======================================================================== -->
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
          <a class="cl-sidebar__item is-active" href="{{ url('/') }}" title="Sistema Memorando">
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
            <span class="cl-sidebar__badge">Ativo</span>
          </a>
        </li>
        <li>
          <a class="cl-sidebar__item" href="#" title="Módulos de Sistema">
            <div class="cl-sidebar__item-left">
              <svg class="cl-sidebar__item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="3" />
                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" />
              </svg>
              <span>Sistema</span>
            </div>
          </a>
        </li>
      </ul>

      <div class="cl-sidebar__section-title">Atalhos Externos</div>
      <ul class="cl-sidebar__nav">
        <li>
          <a class="cl-sidebar__item" href="http://chamados.sapucaiadosul.rs.gov.br/" target="_blank" rel="noopener noreferrer">
            <div class="cl-sidebar__item-left">
              <svg class="cl-sidebar__item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6" />
                <polyline points="15 3 21 3 21 9" />
                <line x1="10" y1="14" x2="21" y2="3" />
              </svg>
              <span>Abrir Chamado TI</span>
            </div>
          </a>
        </li>
        <li>
          <a class="cl-sidebar__item" href="https://webmail.sapucaiadosul.rs.gov.br/" target="_blank" rel="noopener noreferrer">
            <div class="cl-sidebar__item-left">
              <svg class="cl-sidebar__item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                <polyline points="22,6 12,13 2,6" />
              </svg>
              <span>Acessar Webmail</span>
            </div>
          </a>
        </li>
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

  <!-- ========================================================================
       3. Main Content
       ======================================================================== -->
  <main class="cl-main">
    <!-- Breadcrumb (breadcrumb.php do legado) -->
    <nav class="cl-breadcrumb" aria-label="Trilha de navegação" id="breadcrumb">
      <a class="cl-breadcrumb__link" href="{{ url('/') }}">Início</a>
      <span class="cl-breadcrumb__sep">&gt;</span>
      <span class="cl-breadcrumb__current">Memorando</span>
    </nav>

    <!-- Card de Boas-vindas (inicio.php linhas 22-25) com borda animada do login -->
    <section class="cl-welcome-frame" aria-label="Mensagem de boas-vindas">
      <div class="cl-welcome-card">
        <div class="cl-welcome-card__main">
          <h1 class="cl-welcome-card__title">
            Bem vindo, <strong>{{ Auth::user()->name ?? 'Servidor' }}</strong>
          </h1>
        </div>
        <img class="cl-welcome-card__logo" src="{{ asset('img/pmsps.png') }}" alt="Brasão da Prefeitura Municipal" width="160" height="60">
      </div>
    </section>

    <!-- Grid de Botões Principais de Ação (inicio.php linhas 27-35) -->
    <section aria-label="Ações rápidas do sistema">
      <h2 class="cl-section-title">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2" />
        </svg>
        <span>Ações Disponíveis</span>
      </h2>

      <div class="cl-actions-grid">
        <!-- 1. Consultar memorandos (btn-info no legado) -->
        <a class="cl-action-card cl-action-card--consultar" href="#" title="Consultar memorandos">
          <div class="cl-action-card__icon-wrap">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="11" cy="11" r="8" />
              <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
          </div>
          <div class="cl-action-card__body">
            <span class="cl-action-card__tag">Consulta &middot; Acompanhamento</span>
            <h3 class="cl-action-card__title">
              <span>Consultar memorandos</span>
              <svg class="cl-action-card__arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </h3>
            <p class="cl-action-card__desc">Localize despachos, visualize memorandos recebidos, enviados e tramitações em andamento.</p>
          </div>
        </a>

        <!-- 2. Usuários (btn-info no legado) -->
        <a class="cl-action-card cl-action-card--ponto" href="#" title="Usuários">
          <div class="cl-action-card__icon-wrap">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
              <circle cx="9" cy="7" r="4" />
              <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
              <path d="M16 3.13a4 4 0 0 1 0 7.75" />
            </svg>
          </div>
          <div class="cl-action-card__body">
            <span class="cl-action-card__tag">Administração &middot; Usuários</span>
            <h3 class="cl-action-card__title">
              <span>Usuários</span>
              <svg class="cl-action-card__arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </h3>
            <p class="cl-action-card__desc">Acesse a edição de usuários.</p>
          </div>
        </a>

        <!-- 3. Criar memorando (btn-primary no legado) -->
        <a class="cl-action-card cl-action-card--criar" href="#" title="Criar memorando">
          <div class="cl-action-card__icon-wrap">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
              <polyline points="14 2 14 8 20 8" />
              <line x1="12" y1="18" x2="12" y2="12" />
              <line x1="9" y1="15" x2="15" y2="15" />
            </svg>
          </div>
          <div class="cl-action-card__body">
            <span class="cl-action-card__tag">Individual &middot; Novo Documento</span>
            <h3 class="cl-action-card__title">
              <span>Criar memorando</span>
              <svg class="cl-action-card__arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </h3>
            <p class="cl-action-card__desc">Emita uma nova comunicação interna individual para setores ou servidores específicos.</p>
          </div>
        </a>

        <!-- 4. Criar circular (btn-warning no legado) -->
        <a class="cl-action-card cl-action-card--circular" href="#" title="Criar circular">
          <div class="cl-action-card__icon-wrap">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <path d="M22 2L11 13" />
              <path d="M22 2L15 22l-4-9-9-4 22-7z" />
            </svg>
          </div>
          <div class="cl-action-card__body">
            <span class="cl-action-card__tag">Institucional &middot; Coletivo</span>
            <h3 class="cl-action-card__title">
              <span>Criar circular</span>
              <svg class="cl-action-card__arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </h3>
            <p class="cl-action-card__desc">Envie comunicados gerais, circulares administrativas e notificações coletivas.</p>
          </div>
        </a>
      </div>
    </section>

    <!-- Rodapé informativo do sistema -->
    <footer class="cl-footer-info">
      <div>
        <span>Prefeitura Municipal de Sapucaia do Sul - RS  &middot;  SIGEM - Memorando</span>
      </div>
      <div>
        <span>Suporte de TI (WhatsApp) &middot; 51 3451 8065  </span>
      </div>
    </footer>
  </main>

  <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>
