@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Panneau d'administration</a></li>
                <li class="breadcrumb-item active" aria-current="page">Invitations</li>
            </ol>
        </nav>

        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

        <div class="d-flex">
            <h1 class="flex-fill">Gérer les invitations</h1>
        </div>
        <table class="table table-sm">
            <thead class="thead-dark">
            <tr>
                <th>Nom</th>
                <th>Courriel</th>
                <th>Demandé le</th>
                <th colspan="2">Lien</th>
            </tr>
            </thead>
            <tbody>
            @foreach($invitations as $invitation)
                <tr>
                    <td>{{ $invitation->name }}</td>
                    <td>{{ $invitation->email }}</td>
                    <td>{{ $invitation->created_at }}</td>
                    <td><kbd>{{ $invitation->link }}</kbd></td>
                    <td><a href="" class="btn btn-success btn-small">Accepter</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
