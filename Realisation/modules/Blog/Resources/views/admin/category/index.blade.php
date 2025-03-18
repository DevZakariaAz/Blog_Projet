@extends('Blog::layouts.admin')

@section('content')
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('message.list_categories') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('message.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('message.categories') }}</li>
                    </ol>
                </div>
            </div>

            <!-- Search and Buttons Section -->
            <div class="row mb-2">
                <div class="col-md-6">
                    <form action="{{ route('category.index') }}" method="GET">
                        <div class="input-group input-group-sm col-md-12 p-0">
                            <input type="text" name="crud_search_input" id="crud_search_input"
                                   class="form-control" placeholder="{{ __('Search by name') }}"
                                   value="{{ request('crud_search_input') }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-6 text-end">
                    <button class="btn btn-secondary btn-sm ml-2" data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="fas fa-file-import"></i> {{ __('message.import') }}
                    </button>
                    <button class="btn btn-secondary btn-sm ml-2" data-bs-toggle="modal" data-bs-target="#exportModal">
                        <i class="fas fa-file-export"></i> {{ __('message.export') }}
                    </button>
                    <a href="{{ route('category.create') }}" class="btn btn-info btn-sm ml-2">
                        <i class="fas fa-plus"></i> {{ __('message.add_category') }}
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
                    <h3 class="card-title">{{ __('message.table_categories') }}</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Slug') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->slug }}</td>
                                    <td>
                                        <a href="{{ route('category.show', $category) }}" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i> </a>
                                        <a href="{{ route('category.edit', $category) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> </a>
                                        <form action="{{ route('category.destroy', $category) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> </button>
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
            {{ $categories->links('pagination::bootstrap-5') }}
        </div>
    </section>

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('category.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">{{ __('message.import_categories') }}</h5>
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
                <form action="{{ route('category.export') }}" method="GET">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exportModalLabel">{{ __('message.export_categories') }}</h5>
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
