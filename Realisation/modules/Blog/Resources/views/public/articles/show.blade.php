@extends('Blog::layouts.public')

@section('content')
<div class="container mx-auto my-12 px-6">

    <!-- Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-extrabold text-gray-900">Article Details</h1>
    </div>

    <!-- Article Section -->
    <div class="bg-white shadow-xl rounded-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300 p-6 flex flex-col md:flex-row gap-6">
        
        <!-- Image on the Left -->
        <div class="md:w-1/3 w-full flex justify-center">
            <img class="w-64 h-64 object-cover rounded-lg" 
                src="{{ $article->image_url ?: 'https://ui-avatars.com/api/?name=' . urlencode($article->title) . '&background=random&color=fff&bold=true&size=300&length=2' }}" 
                alt="{{ $article->title }}">
        </div>

        <!-- Content on the Right -->
        <div class="md:w-2/3 w-full space-y-4">
            <h2 class="text-3xl font-semibold text-gray-900">{{ $article->title }}</h2>

            <!-- Author and Metadata -->
            <div class="flex flex-wrap gap-4 mb-4 text-sm text-gray-600">
                <p>By <span class="font-medium text-gray-800">{{ $article->user->name }}</span></p>
                <p>Published on <span>{{ $article->created_at->format('F j, Y') }}</span></p>
                <p>Category: 
                    <span class="inline-block bg-gradient-to-r from-purple-400 via-pink-500 to-red-500 text-white text-xs font-semibold rounded-full px-3 py-1">
                        {{ $article->category->name }}
                    </span>
                </p>
            </div>

            <!-- Article Content -->
            <p class="text-lg text-gray-800 leading-relaxed">{{ $article->content }}</p>
        </div>
    </div>

    <!-- 🔥 YouTube-Style Comments Section (Below Article) -->
    <div class="mt-12 max-w-4xl mx-auto">

        <!-- 📝 Comment Input Box -->
        <div class="flex items-start space-x-4 mb-6">
            <img class="w-10 h-10 rounded-full object-cover" 
                src="{{ auth()->user()->profile_picture ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name ?? 'User') . '&background=random&color=fff&size=300&length=1' }}" 
                alt="User">
            <form action="{{ route('public.article.comments.store', $article->id) }}" method="POST" class="w-full">
                @csrf
                <textarea name="content" rows="2" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 transition-all" placeholder="Add a comment..." required></textarea>
                <button type="submit" class="mt-2 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                    Comment
                </button>
            </form>
        </div>

        <!-- 🗨️ Comments List -->
        <h3 class="text-xl font-semibold text-gray-900 mb-4">{{ $article->comments->count() }} Comments</h3>

        @if ($article->comments->isEmpty())
            <p class="text-gray-600">No comments yet. Be the first to comment!</p>
        @else
            <div class="space-y-6">
                @foreach ($article->comments->sortByDesc('created_at') as $comment)
                    <div class="flex space-x-4 border-b border-gray-300 pb-4">
                        <img class="w-10 h-10 rounded-full object-cover" 
                            src="{{ $comment->user->profile_picture ?? 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) . '&background=random&color=fff&size=300&length=1' }}" 
                            alt="{{ $comment->user->name }}">
                        <div class="flex-1">
                            <div class="flex justify-between items-center">
                                <p class="font-medium text-gray-800">{{ $comment->user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>
                            <p class="mt-2 text-gray-700">{{ $comment->content }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Back to Articles Button -->
    <div class="mt-12 text-center">
        <a href="{{ route('public.public.index') }}" class="px-8 py-3 bg-green-600 text-white rounded-lg hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-500 transition-all inline-block">
            Back to Articles
        </a>
    </div>
</div>
@endsection
