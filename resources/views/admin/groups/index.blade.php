@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Panneau d'administration</a></li>
                <li class="breadcrumb-item active" aria-current="page">Groupes</li>
            </ol>
        </nav>

        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

        <div class="d-flex align-items-center">
            <h1 class="flex-fill">Gérer les groupes</h1>
            <a href="{{ route('groups.create') }}" class="btn btn-info">Créer</a>
        </div>
        <table class="table table-sm">
            <thead class="thead-dark">
            <tr>
                <th>Nom</th>
                <th>Description</th>
                <th colspan="2">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($groups as $group)
                <tr>
                    <td>{{ $group->name }}</td>
                    <td>{{ $group->description }}</td>
                    <td><a href="{{ route('groups.edit') }}" class="btn btn-info btn-sm">Modifier</a></td>
                    <td><a href="{{ route('groups.destroy') }}" class="btn btn-danger btn-sm">Supprimer</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
