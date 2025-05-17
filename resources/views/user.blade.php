@extends('layouts.main')

@section('content')
    <div class="container mt-4">
        <h2>Data User</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->nama }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role->nama_role }}</td>
                        <td>
                            <a href="/user/{{ $user->id }}/detail" class="btn btn-success btn-sm">Detail</a>
                            <a href="/user/{{ $user->id }}/edit" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('user.delete', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus?')">
                                    Hapus
                                </button>
                            </form>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
