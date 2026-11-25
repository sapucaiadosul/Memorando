@extends('layouts.app')

@section('title', 'Memorando - Novo Usuário')

@section('content')
  <nav class="cl-breadcrumb" aria-label="Trilha de navegação" id="breadcrumb">
    <a class="cl-breadcrumb__link" href="{{ route('home') }}">Início</a>
    <span class="cl-breadcrumb__sep">&gt;</span>
    <a class="cl-breadcrumb__link" href="{{ route('users.index') }}">Usuários</a>
    <span class="cl-breadcrumb__sep">&gt;</span>
    <span class="cl-breadcrumb__current">Adicionando</span>
  </nav>

  <div class="cl-welcome-frame cl-form-frame">
    <div class="cl-pw-card">
      <h1 class="cl-pw-title">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
          <circle cx="8.5" cy="7" r="4" />
          <line x1="20" y1="8" x2="20" y2="14" />
          <line x1="23" y1="11" x2="17" y2="11" />
        </svg>
        <span>Novo Usuário</span>
      </h1>
      <p class="cl-pw-sub">Preencha os dados abaixo para cadastrar um novo usuário no sistema.</p>

      <form action="{{ route('users.store') }}" method="POST" novalidate>
        @csrf
        @include('users._form')
      </form>
    </div>
  </div>
@endsection
