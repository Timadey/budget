@extends('layouts.theme')

@section ('content')
<div class="page-header">
    <h3 class="page-title"> {{ ('Account')}} </h3>
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="
        {{isset($account) ? route ('account.show', $account->id) :
        route ('account.index') }}
        ">{{$account->account_name ?? 'Accounts'}}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{isset($account) ? 'Edit Account' : 'Add New Account'}}</li>
    </ol>
    </nav>
</div>

<div class="row justify-content-md-center"">
    <div class="col-md-8 grid-margin stretch-card ">
        <div class="card d-flex ">
            <div class="card-body">
                <h4 class="card-title">{{isset($account) ? "Edit $account->account_name" : 'Add New Account'}}</h4>
                <p class="card-description"> {{isset($account) ? 'Edit current account' : 'Add new account'}} to record income and expense </p>
                
                <form class="forms-sample" method="POST" action=@yield('action')>
                @yield('method')
                @csrf

                    <div class="form-group">
                        <label for="account_name">{{('Account Name')}}</label>
                        <input type="text" class="form-control
                        @error('account_name') is-invalid @enderror" name="account_name" id="account_name" 
                            placeholder="Account Name"
                            value="{{$account->account_name ?? old('account_name')}}">
                        @error('account_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="account_description">{{('Account Description')}}</label>
                        <textarea class="form-control @error('account_description') is-invalid @enderror"
                            id="account_description" 
                            name="account_description" row=4>{{$account->account_description ?? old('account_description')}}</textarea>
                        @error('account_description')
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

@section ('custom_js')
<!-- Custom js for this page -->
<script src="{{ asset ('assets/js/file-upload.js') }}"></script>
<script src="{{ asset ('assets/js/typeahead.js') }}"></script>
<script src="{{ asset ('assets/js/select2.js') }}"></script>
<!-- End custom js for this page -->
@endsection