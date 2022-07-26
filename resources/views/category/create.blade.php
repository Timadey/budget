@extends('layouts.theme')

@section('content')
<div class="page-header">
    <h3 class="page-title"> {{ ('Category')}} </h3>
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Categories</a></li>
        <li class="breadcrumb-item active" aria-current="page">New category</li>
    </ol>
    </nav>
</div>

<div class="row justify-content-md-center">
    <div class="col-md-8 grid-margin stretch-card ">
        <div class="card d-flex ">
            <div class="card-body">
                <h4 class="card-title">Category</h4>
                <p class="card-description"> Create a new category</p>
                
                <form class="forms-sample" method="POST"
                action="{{route('category.store')}}">
                @csrf

                    <div class="form-group">
                        <label for="category_name">{{('Category Name')}}</label>
                        <input type="text" class="form-control text-white
                        @error('category_name') is-invalid @enderror" 
                            name="category_name" id="category_name" 
                            placeholder="Category Name"
                            value="{{old('category_name')}}">
                        @error('category_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="category_description">{{('Short Description')}}</label>
                        <textarea class="form-control text-white 
                        @error('category_description') is-invalid @enderror"
                            id="category_description" 
                            name="category_description" row=4>{{old('category_description')}}</textarea>
                        @error('category_description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-icon-text">
                    <i class="mdi mdi-file-check btn-icon-prepend"></i> {{('Save')}} </button>
                </form>
            </div>
        </div>
    </div>
</div> 
@endsection