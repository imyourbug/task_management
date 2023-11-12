@extends('admin.main')
@push('styles')
@endpush
@push('scripts')
@endpush
@section('content')
    <form action="{{ route('admin.accounts.store') }}" method="POST">
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="menu">User name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                            placeholder="Enter username">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="menu">Email</label>
                        <input type="email" class="form-control" id="" name="email" value="{{ old('email') }}"
                            placeholder="Enter email">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="menu">Password</label>
                        <input type="password" class="form-control" id="name" name="password"
                            value="{{ old('password') }}" placeholder="Enter password">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="menu">birthdate</label>
                        <select name="birthdate" class="form-control">
                            <option value="2023">2023</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>Role</label>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="active" value="1" checked
                                name="role">
                            <label for="active" class="custom-control-label">Admin</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="unactive" value="0" name="role">
                            <label for="unactive" class="custom-control-label">User</label>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <label>Gender</label>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="male" value="0" checked
                            name="gender">
                        <label for="male" class="custom-control-label">Male</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="female" value="1" name="gender">
                        <label for="female" class="custom-control-label">Female</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="x" value="2" name="gender">
                        <label for="x" class="custom-control-label">X</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
        @csrf
    </form>
@endsection
