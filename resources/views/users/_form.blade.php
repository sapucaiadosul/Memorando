@php
  $isEdit = isset($user);
@endphp

@if ($errors->any())
  <div class="cl-login03__alert cl-login03__alert--error" role="alert">
    <svg viewBox="0 0 20 20" width="18" height="18" fill="currentColor" aria-hidden="true">
      <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
    </svg>
    <span>{{ $errors->first() }}</span>
  </div>
@endif

<div class="cl-form-section">
  <h2 class="cl-form-section__title">Dados de acesso</h2>

  <div class="cl-form-grid">
    <!-- Nome -->
    <div class="cl-login03__field cl-form-grid__full @error('name') is-error @enderror">
      <label class="cl-login03__label" for="name">Nome completo *</label>
      <input
        class="cl-login03__input"
        id="name"
        name="name"
        type="text"
        required
        autofocus
        value="{{ old('name', $user->name ?? '') }}"
        placeholder="Digite o nome completo">
      @error('name')
        <p class="cl-login03__error">{{ $message }}</p>
      @enderror
    </div>

    <!-- Login -->
    <div class="cl-login03__field @error('login') is-error @enderror">
      <label class="cl-login03__label" for="login">Login *</label>
      <input
        class="cl-login03__input"
        id="login"
        name="login"
        type="text"
        maxlength="20"
        required
        value="{{ old('login', $user->login ?? '') }}"
        placeholder="Ex.: nome.sobrenome ou CPF">
      @error('login')
        <p class="cl-login03__error">{{ $message }}</p>
      @enderror
    </div>

    <!-- E-mail -->
    <div class="cl-login03__field @error('email') is-error @enderror">
      <label class="cl-login03__label" for="email">E-mail</label>
      <input
        class="cl-login03__input"
        id="email"
        name="email"
        type="email"
        value="{{ old('email', $user->email ?? '') }}"
        placeholder="servidor@sapucaiadosul.rs.gov.br">
      @error('email')
        <p class="cl-login03__error">{{ $message }}</p>
      @enderror
    </div>

    <!-- Senha -->
    <div class="cl-login03__field @error('password') is-error @enderror">
      <label class="cl-login03__label" for="password">
        {{ $isEdit ? 'Nova senha (deixe em branco para manter)' : 'Senha *' }}
      </label>
      <div class="cl-login03__pw">
        <input
          class="cl-login03__input"
          id="password"
          name="password"
          type="password"
          autocomplete="new-password"
          {{ $isEdit ? '' : 'required' }}
          placeholder="{{ $isEdit ? 'Opcional na edição' : 'Mínimo de 4 caracteres' }}">
        <button class="cl-login03__eye" type="button" aria-label="Exibir senha" aria-pressed="false" aria-controls="password" data-pw-toggle>
          <svg class="cl-login03__eye-on" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
          <svg class="cl-login03__eye-off" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 3l18 18M10.6 5.1A10.8 10.8 0 0 1 12 5c6.4 0 10 7 10 7a17.6 17.6 0 0 1-3.2 4.1M6.6 6.6C3.9 8.3 2 12 2 12s3.6 7 10 7a9.8 9.8 0 0 0 5.4-1.6M9.9 9.9a3 3 0 0 0 4.2 4.2"/></svg>
        </button>
      </div>
      @error('password')
        <p class="cl-login03__error">{{ $message }}</p>
      @enderror
    </div>

    <!-- Repetir Senha -->
    <div class="cl-login03__field">
      <label class="cl-login03__label" for="password_confirmation">
        {{ $isEdit ? 'Repetir nova senha' : 'Repetir senha *' }}
      </label>
      <div class="cl-login03__pw">
        <input
          class="cl-login03__input"
          id="password_confirmation"
          name="password_confirmation"
          type="password"
          autocomplete="new-password"
          {{ $isEdit ? '' : 'required' }}
          placeholder="Repita a senha informada">
        <button class="cl-login03__eye" type="button" aria-label="Exibir senha" aria-pressed="false" aria-controls="password_confirmation" data-pw-toggle>
          <svg class="cl-login03__eye-on" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
          <svg class="cl-login03__eye-off" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 3l18 18M10.6 5.1A10.8 10.8 0 0 1 12 5c6.4 0 10 7 10 7a17.6 17.6 0 0 1-3.2 4.1M6.6 6.6C3.9 8.3 2 12 2 12s3.6 7 10 7a9.8 9.8 0 0 0 5.4-1.6M9.9 9.9a3 3 0 0 0 4.2 4.2"/></svg>
        </button>
      </div>
    </div>
  </div>
</div>

<div class="cl-form-section">
  <h2 class="cl-form-section__title">Permissões e Situação</h2>

  <div class="cl-checkbox-grid">
    <label class="cl-checkbox-card" for="is_admin">
      <input
        type="checkbox"
        id="is_admin"
        name="is_admin"
        value="1"
        {{ old('is_admin', $user->is_admin ?? false) ? 'checked' : '' }}
        {{ $isEdit && Auth::id() === $user->id ? 'disabled' : '' }}>
      <div>
        <strong>Administrador do sistema</strong>
        <span>Concede acesso total ao gerenciamento de usuários e configurações.</span>
      </div>
    </label>

    <label class="cl-checkbox-card" for="provisoria">
      <input
        type="checkbox"
        id="provisoria"
        name="provisoria"
        value="1"
        {{ old('provisoria', $user->provisoria ?? false) ? 'checked' : '' }}>
      <div>
        <strong>Senha provisória</strong>
        <span>Indica que a senha atual é temporária e deve ser alterada pelo usuário.</span>
      </div>
    </label>

    @if ($isEdit)
      <label class="cl-checkbox-card cl-checkbox-card--danger" for="desativado">
        <input
          type="checkbox"
          id="desativado"
          name="desativado"
          value="1"
          {{ old('desativado', $user->desativado ?? false) ? 'checked' : '' }}
          {{ Auth::id() === $user->id ? 'disabled' : '' }}>
        <div>
          <strong>Usuário desativado</strong>
          <span>Bloqueia o acesso deste usuário sem apagar seu histórico no sistema.</span>
        </div>
      </label>
    @endif
  </div>
</div>

<div class="cl-form-actions">
  <button class="cl-btn-primary" type="submit" id="salvar">
    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
      <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
      <polyline points="17 21 17 13 7 13 7 21" />
      <polyline points="7 3 7 8 15 8" />
    </svg>
    <span>{{ $isEdit ? 'Salvar alterações' : 'Cadastrar usuário' }}</span>
  </button>

  <a class="cl-btn-secondary" href="{{ route('users.index') }}" id="cancelar">
    <span>Cancelar</span>
  </a>
</div>
