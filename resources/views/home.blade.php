@extends('layout.main')
@section('contents')
    <section class="content">
        <div class="container-fluid">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->status_label }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p>{{ $users->first()->id }} | {{ $users->first()->name }} | {{ $users->first()->status_label }}</p>
            <p>{{ $users->last()->id }} | {{ $users->last()->name }} | {{ $users->last()->status_label }}</p>
            <p>{{ $topUser->id }} | {{ $topUser->name }} | {{  $topUser->status_label }}</p>
        </div>
    </section>
@endsection
