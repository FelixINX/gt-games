@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Panneau d'administration</a></li>
            </ol>
        </nav>

        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

        <h1>Bienvenue {{ auth()->user()->name }}!</h1>

        <a href="{{ route('invitations.index') }}" class="btn btn-secondary">Gérer les invitations</a>
    </div>
@endsection
