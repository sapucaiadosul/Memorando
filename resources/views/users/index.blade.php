@extends('layouts.app')

@section('title', 'Memorando - Usuários')

@section('content')
  <!-- Breadcrumb -->
  <nav class="cl-breadcrumb" aria-label="Trilha de navegação" id="breadcrumb">
    <a class="cl-breadcrumb__link" href="{{ route('home') }}">Início</a>
    <span class="cl-breadcrumb__sep">&gt;</span>
    <span class="cl-breadcrumb__current">Usuários</span>
  </nav>

  <!-- Page Header -->
  <div class="cl-page-header">
    <div>
      <h1 class="cl-page-title">Gerenciamento de Usuários</h1>
      <p class="cl-page-sub">Cadastre, edite, desative ou remova usuários com acesso ao sistema.</p>
    </div>
    <div class="cl-page-actions">
      <a class="cl-btn-primary cl-btn-auto" href="{{ route('users.create') }}" id="btn-adicionar-usuario">
        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
          <circle cx="8.5" cy="7" r="4" />
          <line x1="20" y1="8" x2="20" y2="14" />
          <line x1="23" y1="11" x2="17" y2="11" />
        </svg>
        <span>Adicionar Usuário</span>
      </a>
    </div>
  </div>

  <!-- Feedback Messages -->
  @if (session('status'))
    <div class="cl-login03__alert cl-login03__alert--success" role="alert">
      <svg viewBox="0 0 20 20" width="18" height="18" fill="currentColor" aria-hidden="true">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
      </svg>
      <span>{{ session('status') }}</span>
    </div>
  @endif

  @if ($errors->any())
    <div class="cl-login03__alert cl-login03__alert--error" role="alert">
      <svg viewBox="0 0 20 20" width="18" height="18" fill="currentColor" aria-hidden="true">
        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
      </svg>
      <span>{{ $errors->first() }}</span>
    </div>
  @endif

  <!-- Search & Filters (baseado em usuario_pesquisa.php do legado) -->
  <section class="cl-filter-card" aria-label="Pesquisa de usuários">
    <form class="cl-filter-form" action="{{ route('users.index') }}" method="GET">
      <div class="cl-filter-field cl-filter-field--grow">
        <label class="cl-login03__label" for="search">Pesquisar usuário</label>
        <input
          class="cl-login03__input"
          id="search"
          name="search"
          type="text"
          value="{{ $search }}"
          placeholder="Nome ou login...">
      </div>

      <div class="cl-filter-field">
        <label class="cl-login03__label" for="status">Situação</label>
        <select class="cl-login03__input" id="status" name="status">
          <option value="ativos" {{ $status === 'ativos' ? 'selected' : '' }}>Somente ativos</option>
          <option value="desativados" {{ $status === 'desativados' ? 'selected' : '' }}>Somente desativados</option>
          <option value="todos" {{ $status === 'todos' ? 'selected' : '' }}>Todos (incluir desativados)</option>
        </select>
      </div>

      <div class="cl-filter-field">
        <label class="cl-login03__label" for="perfil">Perfil</label>
        <select class="cl-login03__input" id="perfil" name="perfil">
          <option value="todos" {{ $perfil === 'todos' ? 'selected' : '' }}>Todos os perfis</option>
          <option value="admin" {{ $perfil === 'admin' ? 'selected' : '' }}>Administradores</option>
          <option value="comum" {{ $perfil === 'comum' ? 'selected' : '' }}>Usuários comuns</option>
        </select>
      </div>

      <div class="cl-filter-actions">
        <button class="cl-btn-primary cl-btn-auto" type="submit">
          <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <circle cx="11" cy="11" r="8" />
            <line x1="21" y1="21" x2="16.65" y2="16.65" />
          </svg>
          <span>Pesquisar</span>
        </button>

        @if ($search !== '' || $status !== 'ativos' || $perfil !== 'todos')
          <a class="cl-btn-secondary cl-btn-auto" href="{{ route('users.index') }}">Limpar</a>
        @endif
      </div>
    </form>
  </section>

  <!-- Counter (usuario_contador.php do legado) -->
  <div class="cl-table-meta">
    <span class="cl-table-count">
      <strong>{{ $users->total() }}</strong> {{ $users->total() === 1 ? 'usuário encontrado' : 'usuários encontrados' }}
    </span>
  </div>

  <!-- Users Table (usuario_table.php do legado) -->
  <section class="cl-table-card" aria-label="Lista de usuários">
    <div class="cl-table-responsive">
      <table class="cl-table">
        <thead>
          <tr>
            <th class="cl-text-center">ID</th>
            <th>Nome</th>
            <th>Login</th>
            <th class="cl-text-center">Situação</th>
            <th>Último acesso</th>
            <th class="cl-text-right">Ações</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($users as $user)
            <tr class="{{ $user->desativado ? 'is-inactive' : '' }}">
              <td class="cl-text-center cl-text-muted">#{{ $user->id }}</td>
              <td>
                <a class="cl-table-link" href="{{ route('users.edit', $user) }}">
                  {{ $user->name }}
                </a>
                @if ($user->provisoria)
                  <span class="cl-badge cl-badge--amber" title="Senha provisória">Provisória</span>
                @endif
              </td>
              <td><code class="cl-code">{{ $user->login }}</code></td>
              <td class="cl-text-center">
                @if ($user->desativado)
                  <span class="cl-badge cl-badge--danger">Desativado</span>
                @else
                  <span class="cl-badge cl-badge--success">Ativo</span>
                @endif
              </td>
              <td class="cl-text-muted">
                {{ $user->last_login ? $user->last_login->format('d/m/Y H:i') : 'Nunca acessou' }}
              </td>
              <td class="cl-text-right">
                <div class="cl-row-actions">
                  <a class="cl-icon-btn" href="{{ route('users.edit', $user) }}" title="Editar usuário" aria-label="Editar {{ $user->name }}">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                      <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                    </svg>
                  </a>

                  @if (Auth::id() !== $user->id)
                    <form action="{{ route('users.toggle-status', $user) }}" method="POST" style="margin: 0;">
                      @csrf
                      @method('PATCH')
                      <button
                        type="submit"
                        class="cl-icon-btn {{ $user->desativado ? 'cl-icon-btn--success' : 'cl-icon-btn--warning' }}"
                        title="{{ $user->desativado ? 'Reativar usuário' : 'Desativar usuário' }}"
                        aria-label="{{ $user->desativado ? 'Reativar' : 'Desativar' }} {{ $user->name }}">
                        @if ($user->desativado)
                          <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12" />
                          </svg>
                        @else
                          <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="4.93" y1="4.93" x2="19.07" y2="19.07" />
                          </svg>
                        @endif
                      </button>
                    </form>

                    <form
                      action="{{ route('users.destroy', $user) }}"
                      method="POST"
                      style="margin: 0;"
                      onsubmit="return confirm('Tem certeza que deseja excluir o usuário {{ addslashes($user->name) }}?');">
                      @csrf
                      @method('DELETE')
                      <button
                        type="submit"
                        class="cl-icon-btn cl-icon-btn--danger"
                        title="Excluir usuário"
                        aria-label="Excluir {{ $user->name }}">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <polyline points="3 6 5 6 21 6" />
                          <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                        </svg>
                      </button>
                    </form>
                  @endif
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="cl-table-empty">
                Nenhum usuário encontrado para os filtros informados.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if ($users->hasPages())
      <div class="cl-pagination">
        {{ $users->links() }}
      </div>
    @endif
  </section>
@endsection
