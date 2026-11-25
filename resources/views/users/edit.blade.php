@extends('layouts.app')

@section('title', 'Memorando - Editar Usuário')

@section('content')
  <nav class="cl-breadcrumb" aria-label="Trilha de navegação" id="breadcrumb">
    <a class="cl-breadcrumb__link" href="{{ route('home') }}">Início</a>
    <span class="cl-breadcrumb__sep">&gt;</span>
    <a class="cl-breadcrumb__link" href="{{ route('users.index') }}">Usuários</a>
    <span class="cl-breadcrumb__sep">&gt;</span>
    <span class="cl-breadcrumb__current">Editando</span>
  </nav>

  <div class="cl-welcome-frame cl-form-frame">
    <div class="cl-pw-card">
      <h1 class="cl-pw-title">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
          <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
        </svg>
        <span>Editar Usuário: {{ $user->name }}</span>
      </h1>
      <p class="cl-pw-sub">Atualize os dados de acesso, permissões ou situação deste usuário.</p>

      <form action="{{ route('users.update', $user) }}" method="POST" novalidate>
        @csrf
        @method('PUT')
        @include('users._form', ['user' => $user])
      </form>
    </div>
  </div>
@endsection
