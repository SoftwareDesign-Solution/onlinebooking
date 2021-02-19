<?php /** @var App\Models\User[] $users */ ?>

@extends('layouts.cms')

@section('content')
    <div id="users">
        <h1>Users</h1>

        <form class="search-bar" method="GET">
            <input type="search" placeholder="E-Mail, Name oder Telefonnummer" value="{{ $query ?? '' }}" name="query"/>
            <input type="hidden" value="{{ $currentSortBy }}" name="sortBy"/>
            <input type="hidden" value="{{ $currentSortDirection }}" name="sortDirection"/>
            <button class="search-icon" type="submit">
                @svg('assets/icons/search.svg')
            </button>
        </form>

        <div class="scroll-container">
            <table>
                <tr class="header">
                    <th><x-table-sort-arrows sort-by="role"></x-table-sort-arrows> Status</th>
                    <th><x-table-sort-arrows sort-by="email"></x-table-sort-arrows> E-Mail-Adresse</th>
                    <th><x-table-sort-arrows sort-by="name"></x-table-sort-arrows> Name</th>
                    <th><x-table-sort-arrows sort-by="phone"></x-table-sort-arrows> Telefon</th>
                    <th><x-table-sort-arrows sort-by="created_at"></x-table-sort-arrows> Registriert seit</th>
                    <th><x-table-sort-arrows sort-by="email_verified_at"></x-table-sort-arrows> E-Mail bestätigt</th>
                    <th><x-table-sort-arrows sort-by="active"></x-table-sort-arrows> Aktiv</th>
                    <th> Freischalten</th>
                </tr>
                <div class="rows">
                    @foreach ($users as $user)
                        <tr>
                            <td class="{{ $user->role == 'admin' ? 'primary' : ''}}">{{ $user->role ?? 'user' }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td class="{{ $user->email_verified_at ? 'success' : 'error'}}">{{ $user->email_verified_at ? 'Ja' : 'Nein' }}</td>
                            <td class="{{ $user->active ? 'success' : 'error'}}">{{ $user->active ? 'aktiv' : 'inaktiv'}}</td>
                            <td>
                                <x-user-activation-buttons user-id="{{ $user->id }}"></x-user-activation-buttons>
                            </td>
                        </tr>
                    @endforeach
                </div>
            </table>
        </div>
    </div>
@endsection
