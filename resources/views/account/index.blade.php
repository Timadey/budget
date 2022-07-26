@extends ('layouts.theme')

@section ('right nav')
<li class="nav-item dropdown d-none d-lg-block">
    <a class="nav-link btn btn-success create-new-button" id="createbuttonDropdown"
     aria-expanded="false" href="{{route('account.create')}}">+ Add New Account</a>
                  
</li>
@endsection

@section ('content')
<div class="row justify-content-md-center">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row justify-content-between">
                    <h4 class="card-title mb-1">Accounts</h4>
                    <p class="text-muted mb-1">Last Updated</p>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="preview-list">
                            @foreach ($accounts as $account)
                                <div class="preview-item border-bottom">
                                    <div class="preview-thumbnail"><a href="{{route('account.edit', $account->id)}}">
                                        <div >
                                            <h3 class="mdi mdi-pencil-box"></h3>
                                        </div></a>
                                    </div>
                                    <div class="preview-item-content d-sm-flex flex-grow">
                                        <div class="flex-grow">
                                        <a href="/account/{{$account->id}}">
                                            <h5 class="preview-subject">{{($account->account_name)}}</h5>
                                            </a>
                                            <p class="text-muted mb-0">{{($account->account_description)}}...</p>
                                        </div>
                                        <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                            <p class="text-muted">{{$last_updated["$account->updated_at"]}}</p>
                                            <p class="text-muted mb-0">{{$account->transaction_count}} transactions</p>
                                        </div>
                                    </div>
                                    
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection