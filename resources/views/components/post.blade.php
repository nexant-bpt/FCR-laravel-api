@props(['post'] => $post)

<div>
    <div class="mb-4">
        <a href="{{ route('users.posts', $post->user) }}" class="font-bold"> {{ $post->user->name }} </a>
        <span class="text-gray-600">
            {{ $post->created_at->diffForHumans() }}
        </span>
        <p class="mb-2">
            {{ $post->body }}
        </p>

    @can('delete', $post)
        <form action="{{ route('posts.destroy', $post) }}" method="post" class="mr-1">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-blue-500"> Delete Post</button>
        </form> 


    @endcan
    </div>

    <div class="flex items-center">
        @auth



        @if(!$post->likedBy(auth() ->user()))
        <form action="{{ route('post.likes', $post) }}" method="post" class="mr-1">
            @csrf
            <button type="submit" class="text-blue-500"> Like </button>
        </form> 

        @else
        <form action="{{ route('post.likes'), $post }}" method="post" class="mr-1">
            @csrf
            @method('DELETE')

            <button type="submit" class="text-blue-500"> Unlike </button>
        </form> 
        @endif
        <span>  {{ $post->likes->count()? Str::plural('like', 'likes', $post->likes->count()): 0 }} </span>
    

        @endauth
    </div>
</div>