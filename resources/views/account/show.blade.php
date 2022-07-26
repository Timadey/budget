@extends ('layouts.theme')

@section ('right nav')
<li class="nav-item dropdown d-none d-lg-block">
    <a class="nav-link btn btn-success create-new-button" id="createbuttonDropdown" data-toggle="dropdown"
     aria-expanded="false" href="#">+ Log New Transaction</a>
    <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="createbuttonDropdown">
        <h6 class="p-3 mb-0">Type</h6>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item preview-item" href="{{route ('transaction.create', [
            'account' => $account->id,
            'category' => 1])}}"> <!-- Income is hard coded -->
            
        <div class="preview-thumbnail">
            <div class="preview-icon bg-dark rounded-circle">
            <i class="mdi mdi-file-outline text-primary"></i>
            </div>
        </div>
        <div class="preview-item-content">
            <p class="preview-subject ellipsis mb-1">Income</p>
        </div>
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item preview-item" href="{{route ('transaction.create', [
            'account' => $account->id,
            'category' => 2])}}"> <!-- Expense is also hard coded -->
            
        <div class="preview-thumbnail">
            <div class="preview-icon bg-dark rounded-circle">
            <i class="mdi mdi-web text-info"></i>
            </div>
        </div>
        <div class="preview-item-content">
            <p class="preview-subject ellipsis mb-1">Expenditure</p>
        </div>
        </a>
    </div>
                  
</li>
@endsection


@section ('content')

<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">{{$account->account_name}} <a class="mdi mdi-pencil-box" href="{{route('account.edit', $account->id)}}"></a></h1>
                <p class="card-description">{{$account->account_description}}
                    <p>Last Updated: {{$transactions->first()->updated_at ?? $account->updated_at}}</p>
                    <p>Date Created: {{$account->created_at}}</p>
                </p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!-- Total Income -->
    <div class="col-sm-4 grid-margin">
        <div class="card">
        <div class="card-body">
            <h5>Total Income</h5>
            <div class="row">
            <div class="col-8 col-sm-12 col-xl-8 my-auto">
                <div class="d-flex d-sm-block d-md-flex align-items-center">
                <h2 class="mb-0">NGN{{$totalIncome}}</h2>
                <p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p>
                </div>
                <h6 class="text-muted font-weight-normal">11.38% Since last month</h6>
            </div>
            <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                <i class="icon-lg mdi mdi-codepen text-primary ml-auto"></i>
            </div>
            </div>
        </div>
        </div>
    </div>
    <!-- Net profit -->
    <div class="col-sm-4 grid-margin">
        <div class="card">
        <div class="card-body">
            <h5>Net Profit</h5>
            <div class="row">
            <div class="col-8 col-sm-12 col-xl-8 my-auto">
                <div class="d-flex d-sm-block d-md-flex align-items-center">
                <h2 class="mb-0">NGN{{$netProfit}}</h2>
                <p class="text-success ml-2 mb-0 font-weight-medium">+8.3%</p>
                </div>
                <h6 class="text-muted font-weight-normal"> 9.61% Since last month</h6>
            </div>
            <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                <i class="icon-lg mdi mdi-wallet-travel text-danger ml-auto"></i>
            </div>
            </div>
        </div>
        </div>
    </div>
    <!-- Total Expense -->
    <div class="col-sm-4 grid-margin">
        <div class="card">
        <div class="card-body">
            <h5>Total Expense</h5>
            <div class="row">
            <div class="col-8 col-sm-12 col-xl-8 my-auto">
                <div class="d-flex d-sm-block d-md-flex align-items-center">
                <h2 class="mb-0">NGN{{$totalExpense}}</h2>
                <p class="text-danger ml-2 mb-0 font-weight-medium">-2.1% </p>
                </div>
                <h6 class="text-muted font-weight-normal">2.27% Since last month</h6>
            </div>
            <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                <i class="icon-lg mdi mdi-monitor text-success ml-auto"></i>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>
<div class="row ">
    <div class="col-12 grid-margin">
        <div class="card">
        <div class="card-body">
            <h4 class="card-title">Transactions in {{$account->account_name}}</h4>
            <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>
                    <div class="form-check form-check-muted m-0">
                        <label class="form-check-label">
                        <input type="checkbox" class="form-check-input">
                        </label>
                    </div>
                    </th>
                    <th> Amount </th>
                    <th> Third Party </th>
                    <th> Description </th>
                    <th> Date</th>
                    <th> Payment Mode </th>
                    <th> Type </th>
                    <th> Category </th>
                </tr>
                </thead>
                <tbody>
                @foreach ($transactions as $transaction)
                <tr>
                    <td>
                    <div class="form-check form-check-muted m-0">
                        <label class="form-check-label">
                        <input type="checkbox" class="form-check-input">
                        </label>
                    </div>
                    </td>
                    <td >NGN {{$transaction->transaction_amount}} </td>
                    <td>
                    <span class="mdi mdi-account-multiple"></span>
                    <!-- <img src="{{ asset('assets/images/faces/face1.jpg') }}" alt="image" /> -->
                    <span class="pl-2">{{$transaction->third_party}}</span>
                    </td>
                    <td> {{$transaction->transaction_description}} </td>
                    <td> {{$transaction->created_at}} </td>
                    <td> Credit card </td>
                    <td> {{$transaction->category->category_name}} </td>
                    <td>
                    <div class="badge badge-{{$transaction->color}}">{{$transaction->sub_category->sub_category_name}}</div>
                    </td>
                </tr>
                @endforeach
               
                </tbody>
            </table>
            </div>
        </div>
        </div>
    </div>
</div>

@endsection