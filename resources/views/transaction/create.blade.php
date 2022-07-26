@extends ('layouts.theme')

@section ('content')
<div class="page-header">
    <h3 class="page-title"> {{ ('Transaction')}} </h3>
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route ('account.show', $account->id) }}">{{$account->account_name}}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Log {{$category->category_name}}</li>
    </ol>
    </nav>
</div>


<div class="row justify-content-md-center">
    <div class="col-md-8 grid-margin stretch-card ">
        <div class="card d-flex ">
            <div class="card-body">
                <h4 class="card-title">Log {{$category->category_name}}</h4>
                <p class="card-description"> Log a new {{$category->category_name}} under {{$account->account_name}}</p>
                
                <form class="forms-sample" method="POST"
                action="{{route('transaction.store')}}">
                @csrf
                <input type="hidden" name="account_id" value="{{($account->id)}}">
                <input type="hidden" name="category_id" value="{{($category->id)}}">
               
                    <div class="form-group">
                        <label for="transaction_amount">{{('Transaction Amount')}}</label>
                        <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-primary text-white">NGN</span>
                        </div>
                        <input type="number" class="form-control text-white
                        @error('transaction_amount') is-invalid @enderror" name="transaction_amount" id="transaction_amount" 
                            placeholder="Transaction Amount"
                            value="{{old('transaction_amount')}}">
                        </div>
                        @error('transaction_amount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="sub_category_id">{{('Category')}}</label>
                        <select class="form-control text-white
                        @error('sub_category_id') is-invalid @enderror" name="sub_category_id" id="sub_category_id">
                            <option>Choose...</option>
                            @foreach ($sub_categories as $sub_category)
                            <option value="{{$sub_category->id}}">{{$sub_category->sub_category_name}}</option>
                            @endforeach
                        </select>
                        @error('sub_category_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="third_party">{{('Third Party')}}</label>
                        <input type="text" class="form-control text-white @error('third_party') is-invalid @enderror"
                            id="third_party" 
                            name="third_party" placeholder="John  Doe" value="{{old('third_party')}}"> 
                        @error('third_party')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="transaction_description">{{('Short Description')}}</label>
                        <textarea class="form-control text-white @error('transaction_description') is-invalid @enderror"
                            id="transaction_description" 
                            name="transaction_description" row=4>{{old('transaction_description')}}</textarea>
                        @error('transaction_description')
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