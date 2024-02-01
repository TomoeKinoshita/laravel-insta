@extends('layouts.app')

@section('title', 'Admin: Users')

@section('content')

<form action="{{ route('admin.users') }}" method="get">
    <input type="text" name="search" value="{{ $search }}" placeholder="Search names..." class="form-control form-control-sm w-25 mb-3 float-end">
</form>

    <table class="table table-hover bg-white align-middle text-secondary border">
        <thead class="text-secondary table-success text-uppercase small">
            <th></th>
            <th>name</th>
            <th>email</th>
            <th>created at</th>
            <th>status</th>
            <th></th>
        </thead>
        @forelse( $all_users as $user )
            <tr>
                <td>
                    @if($user->avatar)
                        <img src="{{ $user->avatar }}" alt="" class="rounded-circle avatar-md d-block mx-auto">
                    @else
                        <i class="fa-solid fa-circle-user text-secondary icon-md d-block text-center"></i>
                    @endif
                </td>
                <td>
                    <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-dark fw-bold">
                        {{ $user->name }}
                    </a>
                </td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at }}</td>
                <td>
                    @if($user->trashed())
                    {{-- trashed() - true if user is soft-deleted/inactive --}}
                    <i class="fa-regular fa-circle"></i> Inactive
                    @else
                    <i class="fa-solid fa-circle text-success"></i> Active
                    @endif
                </td>

                <td>
                    {{-- deactivate/activate --}}
                    @if($user->id != Auth::user()->id) {{-- != はNOTの意 --}}
                    <div class="dropdown">
                        <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>

                        <div class="dropdown-menu">

                            @if(!$user->trashed())  {{-- if the user is not deactivated --}}
                            <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deactivate-user{{ $user->id }}">
                                <i class="fa-solid fa-user-slash"></i> Deactivate {{ $user->name }}
                            </button>

                            @else
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#activate-user{{ $user->id }}">
                                <i class="fa-solid fa-user-check"></i> Activate {{ $user->name }}
                            </button>
                            @endif
                        </div>

                    </div>
                    @include('admin.users.status')  {{-- modal file --}}
                    @endif
                </td>
            </tr>

        @empty
            <tr>
                <td colspan="6" class="text-center">No users found.</td>
            </tr>
        @endforelse
    </table>

    {{ $all_users->links() }}
    {{-- $all_users is the array we're looping through --}}

@endsection
