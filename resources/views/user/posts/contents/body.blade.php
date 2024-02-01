<div class="row align-items-center">

    <div class="col-auto">
        {{-- heart button --}}  {{-- only my ID and post ID needed --}}
        @if($post->isLiked())  {{-- whether it is liked. make own function here --}}
        {{-- red heart --}}
        <form action="{{ route('like.destroy', $post->id) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="border-0 shadow-none bg-transparent p-0">
                <i class="fa-solid fa-heart text-danger"></i>
            </button>
        </form>

        @else
        {{-- empty heart button --}}
        <form action="{{ route('like.store', $post->id) }}" method="post">
            @csrf
            <button type="submit" class="border-0 shadow-none bg-transparent p-0">
                <i class="fa-regular fa-heart"></i>
            </button>
        </form>
        @endif
    </div>

    <div class="col-auto px-0">
        {{-- no. of likes --}}

        @if($post->likes->count() == 0)
            {{ $post->likes->count() }}
        @else
            <button type="button" data-bs-toggle="modal" data-bs-target="#list-liker-{{ $post->id }}" class="btn shadow-none">
                {{ $post->likes->count() }}
            </button>
        @endif

        @include('user.posts.contents.modals.likes')

    </div>

    <div class="col text-end">
        {{-- categories --}}
        {{-- list of all categories related to that post --}}
        @forelse($post->categoryPosts as $category_post)
                {{-- from eloquent relationship on Post.php --}}
                {{-- categoryPosts hasMany CategoryPost::class --}}
            <div class="badge bg-secondary bg-opacity-50">
                {{ $category_post->category->name }}
                    {{-- category_post belongsTo category on CategoryPost model, and you can get name of the category --}}

            </div>

        @empty
            <div class="badge bg-dark">Uncategorized</div>
                {{-- without a category --}}
        @endforelse

    </div>
</div>

{{-- post owner and description --}}
<a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-dark fw-bold">{{ $post->user->name }}</a>
&nbsp;  {{-- meaning just a space--}}
<span class="fw-light">{{ $post->description }}</span>
<p class="text-uppercase text-muted xsmall">{{ date('M d, Y', strtotime($post->created_at)) }}</p>
