@extends('Blog::layouts.admin')

@section('content')
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('message.list_articles') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('message.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('message.articles') }}</li>
                    </ol>
                </div>
            </div>

            <!-- Search and Buttons Section -->
            <div class="row mb-2">
                <div class="col-md-6">
                    <!-- Search Form on the Left -->
                    <form action="{{ route('article.index') }}" method="GET">
                        <div class="input-group input-group-sm float-left col-md-12 p-0">
                            <input type="text" name="crud_search_input" id="crud_search_input"
                                   class="form-control float-left" placeholder="Recherche by name"
                                   value="{{ request('crud_search_input') }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-6 text-right">
                    <!-- Buttons on the Right -->
                    <button class="btn btn-secondary btn-sm ml-2" data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="fas fa-file-import"></i> {{ __('message.import') }}
                    </button>
                    <button class="btn btn-secondary btn-sm ml-2" data-bs-toggle="modal" data-bs-target="#exportModal">
                        <i class="fas fa-file-export"></i> {{ __('message.export') }}
                    </button>
                    <a href="{{ route('article.create') }}" class="btn btn-info btn-sm ml-2">
                        <i class="fas fa-plus"></i> {{ __('message.add_article') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header info-header">
                    <h3 class="card-title">{{ __('message.table_articles') }}</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>{{ __('message.title') }}</th>
                                <th>{{ __('message.category') }}</th>
                                <th>{{ __('message.user') }}</th>
                                <th>{{ __('message.post_date') }}</th>
                                <th>{{ __('message.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($articles as $article)
                                <tr>
                                    <td>{{ $article->title }}</td>
                                    <td>{{ $article->category->name }}</td>
                                    <td>{{ $article->user->name }}</td>
                                    <td>{{ $article->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('article.show', $article) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-eye"></i> {{ __('message.view') }}
                                        </a>
                                        @can('edit', $article)
                                            <a href="{{ route('article.edit', $article) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-edit"></i> {{ __('message.edit') }}
                                            </a>
                                        @endcan
                                        <form action="{{ route('article.destroy', $article) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> {{ __('message.delete') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center">
            {{ $articles->links('pagination::bootstrap-5') }}
        </div>
    </section>

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('article.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">{{ __('message.import_articles') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="file" name="file" class="form-control" accept=".xls,.xlsx,.csv" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('message.close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('message.import') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Export Modal -->
    <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('article.export') }}" method="GET">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exportModalLabel">{{ __('message.export_articles') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ __('message.choose_export_format') }}</p>
                        <select class="form-select" name="format" required>
                            <option value="xls">Excel (XLS)</option>
                            <option value="csv">CSV</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('message.close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('message.export') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
