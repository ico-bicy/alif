@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form method="get" action="{{ route('search') }}">
                    <div class="form-row">
                        <div class="form-group col-md-10">
                            <input type="text" class="form-control" id="search" name="search" placeholder="Поиск...">
                        </div>

                        <div class="form-group col-md-2">
                            <button class="btn btn-primary">
                                Поиск
                            </button>
                            <button class="btn btn-danger">
                                <a href="{{ route('home') }}" style="text-decoration: none; color: #ffffff; cursor: pointer">
                                    Очистить
                                </a>
                            </button>
                        </div>
                    </div>
                </form>
                <div class="card">
                    <h2 class="card-header">{{ __('Пользователи') }}</h2>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ID</th>
                                <th scope="col">Имя</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Доп E-mail</th>
                                <th scope="col">Номер</th>
                                <th scope="col">Доп номер</th>
                                <th scope="col">Время создания</th>
                                <th scope="col">Время изменения</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $key => $user)
                                <tr>
                                    <th scope="row">
                                        <a href="{{ route('update', ['id' => $user->id]) }}">{{ $key + 1 }}</a>
                                    </th>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->additional_email }}</td>
                                    <td>{{ $user->contact_phone }}</td>
                                    <td>{{ $user->additional_contact_phone }}</td>
                                    <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at)->format('Y-m-d') }}</td>
                                    <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $user->updated_at)->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $users->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
