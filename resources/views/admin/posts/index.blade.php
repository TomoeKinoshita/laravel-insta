@extends('layouts.app')

@section('title', 'Admin: Posts')

@section('content')

<form action="{{ route('admin.posts') }}" method="get">
    <input type="text" name="search" value="{{ $search }}" placeholder="Search posts..." class="form-control form-control-sm w-25 mb-3 float-end">
</form>

    <table class="table table-hover bg-white align-middle text-secondary border">
        <thead class="text-secondary table-primary text-uppercase small">
            <th></th>
            <th></th>
            <th>category</th>
            <th>owner</th>
            <th>created at</th>
            <th>status</th>
            <th></th>
        </thead>
        @forelse( $all_posts as $post )
        <tr>
            <td class="text-center">{{ $post->id }}</td>  {{-- post id --}}
            <td>  {{-- image --}}
                <a href="{{ route('post.show', $post->id) }}">
                    <img src="{{ $post->image }}" alt="image" class="img-lg">
                </a>
            </td>
            <td>  {{--categories--}}
                @forelse ( $post->categoryPosts as $category_post )
                    {{-- list of all categories related to that post --}}
                    {{-- from eloquent relationship on Post.php --}}
                    {{-- categoryPosts hasMany CategoryPost::class --}}
                <div class="badge bg-secondary bg-opacity-50">
                    {{ $category_post->category->name }}
                </div>
                @empty
                <div class="text-secondary">
                    Uncategorized
                </div>
                @endforelse
            </td>
            <td>  {{-- post owner name --}}
                <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-dark">{{ $post->user->name }}</a>
            </td>
            <td>{{ $post->created_at }}</td>
            <td>  {{--status--}}
                @if($post->trashed())
                <i class="fa-solid fa-circle-minus"></i> Hidden
                @else
                <i class="fa-solid fa-circle text-primary"></i> Visible
                @endif
            </td>
            <td>  {{-- ... button (modal) --}}
                <div class="dropdown">
                    <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-ellipsis"></i>
                    </button>

                    <div class="dropdown-menu">

                        @if(!$post->trashed())
                        <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#hide-post{{ $post->id }}">
                            <i class="fa-solid fa-eye-slash"></i> Hide post {{ $post->id }}
                        </button>

                        @else
                        <button class="dropdown-item text-dsuccess" data-bs-toggle="modal" data-bs-target="#unhide-post{{ $post->id }}">
                            <i class="fa-solid fa-eye"></i> Unhide post {{ $post->id }}
                        </button>
                        @endif
                    </div>
                </div>

                @include('admin.posts.status')
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center">No posts found.</td>
        </tr>
        @endforelse
    </table>

    {{ $all_posts->links() }}

@endsection
