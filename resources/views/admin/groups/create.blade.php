@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Panneau d'administration</a></li>
                <li class="breadcrumb-item"><a href="{{ route('groups.index') }}">Groupes</a></li>
                <li class="breadcrumb-item active" aria-current="page">Création</li>
            </ol>
        </nav>

        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

        <div class="d-flex align-items-center">
            <h1 class="flex-fill">Créer un groupe</h1>
        </div>


    </div>
@endsection
