<div class="mt-3">
    <form action="{{ route('comment.store', $post->id) }}" method="post">
        @csrf
        <div class="input-group">
            <textarea name="comment_body{{ $post->id }}" rows="1" class="form-control form-control-sm" placeholder="Add a comment...">{{ old('comment_body'.$post->id) }}</textarea>
                {{-- make the comment name unique, we need {{ $post->id }} --}}
                {{-- for example, comment_body1 --}}
            <button type="submit" class="btn btn-sm btn-outline-secondary">Post</button>
        </div>

        @error('comment_body'.$post->id)  {{-- make it string, for example, comment_body2 --}}
            <div class="text-danger xsmall">{{ $message }}</div>
        @enderror

    </form>
</div>
