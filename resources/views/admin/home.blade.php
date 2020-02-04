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

        <div class="card-deck">
            <div class="card bg-secondary text-white">
                <div class="card-body">
                    <h5 class="card-title">X invitations à approuver</h5>
                    <a href="{{ route('invitations.index') }}" class="card-link stretched-link">Gérer les invitations</a>
                </div>
            </div>
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Y groupes</h5>
                    <a href="{{ route('groups.index') }}" class="card-link stretched-link">Gérer les groupes</a>
                </div>
            </div>
        </div>

    </div>
@endsection
