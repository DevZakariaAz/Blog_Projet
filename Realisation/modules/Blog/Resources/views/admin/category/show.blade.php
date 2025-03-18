@extends('Blog::layouts.admin')

@section('content')
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-3 align-items-center">
                <div class="col-md-6">
                    <h1 class="h3 mb-0">Category Details</h1>
                </div>
                <div class="col-md-6 text-md-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Accueil</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Categories</a></li>
                            <li class="breadcrumb-item active" aria-current="page">View</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row justify-content-end">
                <div class="col-auto">
                    <a href="{{ route('category.edit', $category) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit mr-1"></i> Modify
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Category Details -->
    <section class="content">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ $category->name }}</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Name</th>
                                <td>{{ $category->name }}</td>
                            </tr>
                            <tr>
                                <th>Slug</th>
                                <td>{{ $category->slug }}</td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ $category->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('category.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Categories
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
