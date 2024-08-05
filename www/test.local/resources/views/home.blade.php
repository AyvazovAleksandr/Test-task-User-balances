@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <balance-component></balance-component>
                <div class="card-body">
                        <operation-component></operation-component>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
