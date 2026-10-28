<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Memorando - Trocar Senha</title>
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

      <a class="cl-navbar__brand" href="{{ url('/') }}" aria-label="Memorando Início">
        <img class="cl-navbar__logo" src="{{ asset('img/pmsps.png') }}" alt="Prefeitura Municipal" width="90" height="34">
        <span class="cl-navbar__title">Memorando</span>
        <span class="cl-navbar__badge">SiGeM</span>
      </a>
    </div>

    <nav class="cl-navbar__right" aria-label="Menu de navegação superior">
      <!-- Trocar senha (ativo) -->
      <a class="cl-nav-link is-active" href="{{ route('password.change') }}" title="Trocar senha">
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

  <!-- Sidebar Drawer (menu_grupos) -->
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
          <a class="cl-sidebar__item" href="{{ url('/') }}" title="Sistema Memorando">
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
    <!-- Breadcrumb (breadcrumb.php do legado) -->
    <nav class="cl-breadcrumb" aria-label="Trilha de navegação" id="breadcrumb">
      <a class="cl-breadcrumb__link" href="{{ url('/') }}">Início</a>
      <span class="cl-breadcrumb__sep">&gt;</span>
      <span class="cl-breadcrumb__current">Trocar senha</span>
    </nav>

    <!-- Card de Troca de Senha (login_senha.php do legado com visual da tela de login) -->
    <div class="cl-welcome-frame cl-pw-frame">
      <div class="cl-pw-card">
        <h1 class="cl-pw-title">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
          </svg>
          <span>Trocar senha</span>
        </h1>
        @if (session('status'))
          {{-- Estado de sucesso: somente mensagem + botão Voltar, sem formulário --}}
          <p class="cl-pw-sub">Sua senha foi alterada com sucesso.</p>
          <div class="cl-login03__alert cl-login03__alert--success" role="alert" style="margin-bottom: 24px;">
            <svg viewBox="0 0 20 20" width="18" height="18" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span>{{ session('status') }}</span>
          </div>
          <div class="cl-form-actions" style="margin-top: 4px;">
            <a class="cl-btn-primary" href="{{ route('home') }}" id="voltar">
              <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="15 18 9 12 15 6" /></svg>
              <span>Voltar</span>
            </a>
          </div>
        @else
          {{-- Estado normal: subtítulo + erros de validação --}}
          <p class="cl-pw-sub">Preencha os dados abaixo para alterar sua senha de acesso.</p>
          @if ($errors->any())
            <div class="cl-login03__alert cl-login03__alert--error" role="alert">
              <svg viewBox="0 0 20 20" width="18" height="18" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
              </svg>
              <span>{{ $errors->first() }}</span>
            </div>
          @endif

          <!-- Formulário idêntico ao legado (login_senha.php): senha_atual, nova_senha, repita_senha -->
          <form id="f_form" action="{{ route('password.update') }}" method="POST" novalidate style="width: 100%; box-sizing: border-box;">
          @csrf
          <input name="form_name" type="hidden" value="senha">

          <!-- 1. Senha atual -->
          <div class="cl-login03__field @error('senha_atual') is-error @enderror" data-field>
            <label class="cl-login03__label" for="senha_atual">Senha atual</label>
            <div class="cl-login03__pw">
              <input 
                class="cl-login03__input" 
                id="senha_atual" 
                name="senha_atual" 
                type="password" 
                autocomplete="current-password" 
                required 
                autofocus
                placeholder="Digite a senha atual"
                aria-describedby="senha_atual_err">
              <button class="cl-login03__eye" type="button" aria-label="Exibir senha" aria-pressed="false" aria-controls="senha_atual" data-pw-toggle>
                <svg class="cl-login03__eye-on" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                <svg class="cl-login03__eye-off" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 3l18 18M10.6 5.1A10.8 10.8 0 0 1 12 5c6.4 0 10 7 10 7a17.6 17.6 0 0 1-3.2 4.1M6.6 6.6C3.9 8.3 2 12 2 12s3.6 7 10 7a9.8 9.8 0 0 0 5.4-1.6M9.9 9.9a3 3 0 0 0 4.2 4.2"/></svg>
              </button>
            </div>
            <p class="cl-login03__error" id="senha_atual_err" data-error>
              @error('senha_atual') {{ $message }} @enderror
            </p>
          </div>

          <!-- 2. Nova senha -->
          <div class="cl-login03__field @error('nova_senha') is-error @enderror" data-field>
            <label class="cl-login03__label" for="nova_senha">Nova senha</label>
            <div class="cl-login03__pw">
              <input 
                class="cl-login03__input" 
                id="nova_senha" 
                name="nova_senha" 
                type="password" 
                autocomplete="new-password" 
                required 
                placeholder="Digite a nova senha"
                aria-describedby="nova_senha_err">
              <button class="cl-login03__eye" type="button" aria-label="Exibir senha" aria-pressed="false" aria-controls="nova_senha" data-pw-toggle>
                <svg class="cl-login03__eye-on" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                <svg class="cl-login03__eye-off" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 3l18 18M10.6 5.1A10.8 10.8 0 0 1 12 5c6.4 0 10 7 10 7a17.6 17.6 0 0 1-3.2 4.1M6.6 6.6C3.9 8.3 2 12 2 12s3.6 7 10 7a9.8 9.8 0 0 0 5.4-1.6M9.9 9.9a3 3 0 0 0 4.2 4.2"/></svg>
              </button>
            </div>
            <p class="cl-login03__error" id="nova_senha_err" data-error>
              @error('nova_senha') {{ $message }} @enderror
            </p>
          </div>

          <!-- 3. Repita a nova senha -->
          <div class="cl-login03__field @error('repita_senha') is-error @enderror" data-field>
            <label class="cl-login03__label" for="repita_senha">Repita a nova senha</label>
            <div class="cl-login03__pw">
              <input 
                class="cl-login03__input" 
                id="repita_senha" 
                name="repita_senha" 
                type="password" 
                autocomplete="new-password" 
                required 
                placeholder="Repita a nova senha"
                aria-describedby="repita_senha_err">
              <button class="cl-login03__eye" type="button" aria-label="Exibir senha" aria-pressed="false" aria-controls="repita_senha" data-pw-toggle>
                <svg class="cl-login03__eye-on" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                <svg class="cl-login03__eye-off" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 3l18 18M10.6 5.1A10.8 10.8 0 0 1 12 5c6.4 0 10 7 10 7a17.6 17.6 0 0 1-3.2 4.1M6.6 6.6C3.9 8.3 2 12 2 12s3.6 7 10 7a9.8 9.8 0 0 0 5.4-1.6M9.9 9.9a3 3 0 0 0 4.2 4.2"/></svg>
              </button>
            </div>
            <p class="cl-login03__error" id="repita_senha_err" data-error>
              @error('repita_senha') {{ $message }} @enderror
            </p>
          </div>

          <!-- Botões do legado: Salvar e Cancelar -->
          <div class="cl-form-actions">
            <button class="cl-btn-primary" type="submit" id="salvar">
              <span>Salvar</span>
            </button>
            <a class="cl-btn-secondary" href="{{ route('home') }}" id="cancelar">
              <span>Cancelar</span>
            </a>
          </div>
        </form>
        @endif
      </div>
    </div>

    <!-- Rodapé -->
    <footer class="cl-footer-info">
      <div>
        <span>Prefeitura Municipal &middot; SiGeM Memorando</span>
      </div>
      <div>
        <span>Suporte de TI: Ramal 8123 &middot; <a href="http://chamados.sapucaiadosul.rs.gov.br/" target="_blank" rel="noopener noreferrer">Abrir Chamado</a></span>
      </div>
    </footer>
  </main>

  <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>
