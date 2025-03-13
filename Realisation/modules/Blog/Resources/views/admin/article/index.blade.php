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
        </div>
        <div class="container-fluid">
            <div class="row mb-2 justify-content-end">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a href="{{ Route('article.create') }}" class="btn btn-primary btn-sm p-2 text-white">
                            <i class="fas fa-plus"></i> {{ __('message.add_article') }}
                        </a>
                        <!-- Export Button -->
                        <button class="btn btn-success btn-sm p-2" data-bs-toggle="modal" data-bs-target="#exportModal">
                            <i class="fas fa-download"></i> {{ __('message.export') }}
                        </button>
                        <!-- Import Button -->
                        <button class="btn btn-warning btn-sm p-2" data-bs-toggle="modal" data-bs-target="#importModal">
                            <i class="fas fa-upload"></i> {{ __('message.import') }}
                        </button>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('message.table_articles') }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>{{ __('message.number') }}</th>
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
                                    <td>{{ $article->id }}</td>
                                    <td>{{ $article->title }}</td>
                                    <td>{{ $article->category->name }}</td>
                                    <td>{{ $article->user->name }}</td>
                                    <td>{{ $article->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ Route('article.show', $article) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-eye"></i> {{ __('message.view') }}
                                        </a>
                                        @can('edit', $article)
                                            <a href="{{ Route('article.edit', $article) }}" class="btn btn-info btn-sm">
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
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        {{ $articles->links('pagination::bootstrap-5') }}
    </section>

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('article.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Import Articles</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="file" name="file" class="form-control" accept=".xls,.xlsx,.csv">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
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
                        <h5 class="modal-title" id="exportModalLabel">Export Articles</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Choose the format for export:</p>
                        <select class="form-select" name="format">
                            <option value="xls">Excel (XLS)</option>
                            <option value="csv">CSV</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Export</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
