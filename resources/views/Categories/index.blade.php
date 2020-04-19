@extends('layouts.app')
@section('title', 'Kategorijos')
@section('content')

@if (Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">Success!</h4>
        <p>{{ Session::get('success') }}</p>

        <button type="button" class="close" data-dismiss="alert aria-label="Close>
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (Session::has('errors'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">{{__('categories.error')}}</h4>
        <p>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        </p>

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="container py-3">

    <div class="modal" tabindex="-1" role="dialog" id="editCategoryModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('categories.edit')}}</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" value="" placeholder="{{__('categories.name')}}" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('categories.close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('categories.update')}}</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    <h3>{{__('categories.title')}}</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($categories as $category)
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    {{ $category->name }}

                                    <div class="button-group d-flex">
                                        <button type="button" class="btn btn-sm btn-primary mr-1 edit-category" data-toggle="modal" data-target="#editCategoryModal" data-id="{{ $category->id }}" data-name="{{ $category->name }}">{{__('categories.edit')}}</button>
                                        <form action="{{ route('category.destroy', $category->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-danger">{{__('categories.delete')}}</button>
                                        </form>

                                    </div>
                                </div>

                                @if ($category->children)
                                    <ul class="list-group mt-2">
                                        @foreach ($category->children as $child)
                                            <li class="list-group-item">
                                                <div class="d-flex justify-content-between">
                                                    {{ $child->name }}
                                                    <div class="button-group d-flex">
                                                        <button type="button" class="btn btn-sm btn-primary mr-1 edit-category" data-toggle="modal" data-target="#editCategoryModal" data-id="{{ $child->id }}" data-name="{{ $child->name }}">
                                                            {{__('categories.edit')}}</button>

                                                        <form action="{{ route('category.destroy', $child->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit" class="btn btn-sm btn-danger">{{__('categories.delete')}}</button>
                                                        </form>
                                                    </div>

                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>{{__('categories.create')}}</h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('category.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <select class="form-control" name="parent_id">
                                <option value="">{{__('categories.parent')}}</option>

                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="{{__('categories.name')}}" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">{{__('categories.create')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.edit-category').on('click', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var url = "{{ url('update') }}/" + id;

        $('#editCategoryModal form').attr('action', url);
        $('#editCategoryModal form input[name="name"]').val(name);
    });
</script>
@endsection
