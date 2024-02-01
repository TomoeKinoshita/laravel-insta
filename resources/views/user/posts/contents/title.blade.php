<div class="card-header bg-white py-3">
    <div class="row align-items-center">

        {{-- icon/avatar --}}
        <div class="col-auto">
            <a href="{{ route('profile.show', $post->user->id) }}">  {{--$post belongsTo user, and get the ID--}}
                @if($post->user->avatar)
                <img src="{{ $post->user->avatar }}" alt="" class="rounded-circle avatar-sm">
                @else
                <i class="fa-solid fa-circle-user icon-sm text-secondary"></i>
                @endif
            </a>
        </div>

        {{-- user name --}}
        <div class="col ps-0">
            <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-dark">
                {{ $post->user->name }}  {{-- using eloquent relationship --}}
            </a>
        </div>

        {{-- buttons --}}
        <div class="col-auto">
            <div class="dropdown">
                <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-ellipsis"></i>
                </button>

                @if($post->user_id == Auth::user()->id)
                    {{-- edit/delete --}}
                    <div class="dropdown-menu">
                        {{-- edit --}}
                        <a href="{{ route('post.edit', $post->id) }}" class="dropdown-item">
                            <i class="fa-regular fa-pen-to-square"></i> Edit
                        </a>
                        {{-- delete --}}
                        <button class="text-danger dropdown-item" data-bs-toggle="modal" data-bs-target="#delete-post-{{ $post->id }}">
                            {{-- "data-bs-toggle" tells this button is going to open a modal. --}}
                            {{-- "data-bs-target" tells which modal is going to open --}}
                            <i class="fa-regular fa-trash-can"></i> Delete
                        </button>
                    </div>

                    @include('user.posts.contents.modals.delete')
                    {{-- hidden for each post --}}

                @else

                    @if($post->user->isFollowed())  {{-- if the post owner is followed, then--}}
                    {{-- unfollow (if it's not your post) --}}
                    <div class="dropdown-menu">
                        <form action="{{ route('follow.destroy', $post->user->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item text-danger">Unfollow</button>
                        </form>
                    </div>

                    @else
                    {{-- follow --}}
                    <div class="dropdown-menu">
                        <form action="{{ route('follow.store', $post->user->id) }}" method="post">
                            @csrf
                            <button type="submit" class="dropdown-item text-primary">Follow</button>
                        </form>
                    </div>
                    @endif

                @endif
            </div>
        </div>
    </div>
</div>
