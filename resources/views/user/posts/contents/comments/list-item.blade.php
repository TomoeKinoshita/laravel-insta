<div class="mb-2">
    <a href="{{ route('profile.show', $comment->user->id) }}" class="text-decoration-none text-dark fw-bold">{{ $comment->user->name }}</a>
    &nbsp;
    {{ $comment->body }}
    <div>
        <span class="fw-light text-muted xsmall">{{ date('D, M d, Y', strtotime($comment->created_at)) }}</span>

        {{-- if the comment is written by the logged-in user --}}
        @if($comment->user_id == Auth::user()->id)
        &middot;
        <form action="{{ route('comment.destroy', $comment->id) }}" class="d-inline" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn shadow-none p-0 xsmall text-danger">Delete</button>
        </form>
        {{-- endif --}}
        @endif

    </div>
</div>
