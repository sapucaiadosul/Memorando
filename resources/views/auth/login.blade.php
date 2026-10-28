<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Memorando - Entrar</title>
  <link rel="icon" href="{{ asset('favicon.ico') }}">
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
  <main class="cl-login03" aria-labelledby="cl-login03-brand-title">
    <div class="cl-login03__glow" aria-hidden="true"></div>

    <a class="cl-login03__brand" href="{{ url('/') }}" aria-label="Memorando">
      <h1 class="cl-login03__brand-title" id="cl-login03-brand-title">Memorando</h1>
    </a>

    <div class="cl-login03__frame">
      <div class="cl-login03__card">
        <div data-view>
          <div class="cl-login03__logo-wrap">
            <img class="cl-login03__logo" src="{{ asset('img/pmsps.png') }}" alt="Prefeitura Municipal" width="160" height="54">
          </div>

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

          <form class="cl-login03__form" action="{{ route('login') }}" method="POST" data-form novalidate>
            @csrf

            <div class="cl-login03__field @error('usuario_login') is-error @enderror" data-field>
              <label class="cl-login03__label" for="usuario_login">Usuário</label>
              <input 
                class="cl-login03__input" 
                id="usuario_login" 
                name="usuario_login" 
                type="text" 
                autocomplete="username" 
                required 
                autofocus
                value="{{ old('usuario_login') }}"
                placeholder="Digite seu usuário" 
                title="Digite seu usuário"
                data-msg="Preencha o login"
                aria-describedby="usuario_login_err">
              <p class="cl-login03__error" id="usuario_login_err" data-error>
                @error('usuario_login') {{ $message }} @enderror
              </p>
            </div>

            <div class="cl-login03__field @error('usuario_senha') is-error @enderror" data-field>
              <div class="cl-login03__row">
                <label class="cl-login03__label" for="usuario_senha">Senha</label>
              </div>
              <div class="cl-login03__pw">
                <input 
                  class="cl-login03__input" 
                  id="usuario_senha" 
                  name="usuario_senha" 
                  type="password" 
                  autocomplete="current-password" 
                  required 
                  placeholder="Digite sua senha" 
                  title="Digite sua senha"
                  data-msg="Preencha a senha" 
                  aria-describedby="usuario_senha_err">
                <button class="cl-login03__eye" type="button" aria-label="Exibir senha" aria-pressed="false" aria-controls="usuario_senha" data-pw-toggle>
                  <svg class="cl-login03__eye-on" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                  <svg class="cl-login03__eye-off" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 3l18 18M10.6 5.1A10.8 10.8 0 0 1 12 5c6.4 0 10 7 10 7a17.6 17.6 0 0 1-3.2 4.1M6.6 6.6C3.9 8.3 2 12 2 12s3.6 7 10 7a9.8 9.8 0 0 0 5.4-1.6M9.9 9.9a3 3 0 0 0 4.2 4.2"/></svg>
                </button>
              </div>
              <p class="cl-login03__error" id="usuario_senha_err" data-error>
                @error('usuario_senha') {{ $message }} @enderror
              </p>
            </div>

            <button class="cl-login03__submit" type="submit" id="entrar">Entrar</button>
          </form>

          <div class="cl-login03__help">
            <p>Se você ainda não alterou sua senha,</p>
            <p>digite seu <strong>CPF</strong> nos campos <strong>USUÁRIO</strong> e <strong>SENHA</strong>.</p>
            <p>
              <a href="http://ti.esteio.rs.gov.br/mudasenha" target="_blank" rel="noopener noreferrer">
                <span>Clique aqui caso queira alterar sua senha</span>
                <svg viewBox="0 0 20 20" width="13" height="13" fill="currentColor" aria-hidden="true">
                  <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"/>
                  <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"/>
                </svg>
              </a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </main>
  <script src="{{ asset('js/login.js') }}"></script>
</body>
</html>
