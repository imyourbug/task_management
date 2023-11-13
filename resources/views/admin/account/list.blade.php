@extends('admin.main')
@push('styles')
@endpush
@push('scripts')
@endpush
@section('content')
    <table class="table">
        <thead>
            <tr>
                <th>User name</th>
                <th>Email</th>
                <th>birthdate</th>
                <th>Gender</th>
                <th>Role</th>
                <th>Last update</th>
                <th>Actions</th>
            </tr>
        <tbody>
            @foreach ($users as $key => $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->birthdate }}</td>
                    <td>{{ $user->gender == 0 ? 'Male' : ($user->gender == 1 ? 'Female' : 'X') }}</td>
                    <td>{{ $user->role == 1 ? 'Admin' : 'User' }}</td>
                    <td>{{ $user->updated_at === null ? '' : $user->updated_at->format('H:m:s d-m-Y') }}</td>
                    <td><a class="btn btn-primary btn-sm" href='{{route('admin.accounts.show', ['id' => $user->id])}}'>
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{route('admin.accounts.delete', ['id' => $user->id])}}" class="btn btn-danger btn-sm"
                            onclick="return confirm('Bạn có muốn xóa?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
        </thead>
    </table>
@endsection
