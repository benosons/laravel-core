@extends('layouts.app')

@section('title', 'User Details')
@section('page-title', 'User Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
    <li class="breadcrumb-item active">Details</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar-md">
                                    <span class="avatar-title rounded-circle bg-primary text-white font-size-24">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1 align-self-center">
                                <div class="text-muted">
                                    <h5>{{ $user->name }}</h5>
                                    <p class="mb-1">{{ $user->email }}</p>
                                    <p class="mb-0">ID: #{{ $user->id }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 align-self-center">
                        <div class="text-lg-center mt-4 mt-lg-0">
                            <div class="row">
                                <div class="col-6">
                                    <div>
                                        <p class="text-muted text-truncate mb-2">Roles</p>
                                        <h5 class="mb-0">{{ $user->roles->count() }}</h5>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div>
                                        <p class="text-muted text-truncate mb-2">Member Since</p>
                                        <h5 class="mb-0">{{ $user->created_at->format('M Y') }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 d-none d-lg-block">
                        <div class="clearfix mt-4 mt-lg-0">
                            <div class="text-end">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary waves-effect waves-light">
                                    <i class="bx bx-edit-alt me-1"></i> Edit User
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
        </div>
    </div>
</div>
<!-- end row -->

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">User Information</h4>
                
                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
                        <tbody>
                            <tr>
                                <th scope="row">Full Name :</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Email :</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Roles :</th>
                                <td>
                                    @foreach($user->roles as $role)
                                        <span class="badge badge-soft-primary font-size-12">{{ $role->name }}</span>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Created At :</th>
                                <td>{{ $user->created_at->format('d M, Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Updated At :</th>
                                <td>{{ $user->updated_at->format('d M, Y H:i') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="bx bx-arrow-back me-1"></i> Back to List
                    </a>
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                        <i class="bx bx-edit-alt me-1"></i> Edit User
                    </a>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bx bx-trash-alt me-1"></i> Delete User
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
