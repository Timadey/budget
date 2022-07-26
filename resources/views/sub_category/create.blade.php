@extends('layouts.theme')

@section('content')
<div class="page-header">
    <h3 class="page-title"> {{ ('Sub Category')}} </h3>
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Sub Categories</a></li>
        <li class="breadcrumb-item active" aria-current="page">New  Sub Category</li>
    </ol>
    </nav>
</div>

<div class="row justify-content-md-center">
    <div class="col-md-8 grid-margin stretch-card ">
        <div class="card d-flex ">
            <div class="card-body">
                <h4 class="card-title">Sub Category</h4>
                <p class="card-description"> Create a new sub category</p>
                
                <form class="forms-sample" method="POST"
                action="{{route('subcategory.store')}}">
                @csrf
                    <div class="form-group">
                        <label for="category_id">{{('Category')}}</label>
                        <select class="form-control text-white
                        @error('category_id') is-invalid @enderror" name="category_id" id="category_id">
                            <option>Choose...</option>
                            @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>

                        @error('category_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="sub_category_name">{{('Sub Category Name')}}</label>
                        <input type="text" class="form-control text-white
                        @error('sub_category_name') is-invalid @enderror" 
                            name="sub_category_name" id="sub_category_name" 
                            placeholder="Sub Category Name"
                            value="{{old('sub_category_name')}}">
                        @error('sub_category_name')
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