@extends('Blog::layouts.admin')

@section('content')
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-3 align-items-center">
                <div class="col-md-6">
                    <h1 class="h3 mb-0">Article Details</h1>
                </div>
                <div class="col-md-6 text-md-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Accueil</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('article.index') }}">Articles</a></li>
                            <li class="breadcrumb-item active" aria-current="page">View</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row justify-content-end">
                <div class="col-auto">
                    <a href="{{ route('article.edit', $article) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit mr-1"></i> Modify
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Article Details -->
    <section class="content">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ $article->title }}</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Title</th>
                                <td>{{ $article->title }}</td>
                            </tr>
                            <tr>
                                <th>Content</th>
                                <td>{{ $article->content }}</td>
                            </tr>
                            <tr>
                                <th>Author</th>
                                <td>{{ $article->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Category</th>
                                <td>{{ $article->category->name }}</td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ $article->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('comment.indexByArticle', $article) }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-comments mr-1"></i> View Comments
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
