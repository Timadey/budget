@extends('layouts.forms.account')

@section('action')
"{{route('account.update', $account->id)}}"
@endsection

@section('method')
@method('PATCH')
@endsection