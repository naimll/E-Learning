@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2">
            <div class="card" style="text-align: center">
                <div class="card-header" sty>Usuarios</div>
                <div class="card-body"><div style="font-size: 50px;">{{ $totalUsers }}</div></div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Welcome {{ auth()->user()->name }}</div>


                <div class="fb-comments" data-href="{{ Request::url()}}" data-order-by="social" data-width="100%" data-numposts="10"></div>
            </div>
        </div>
    </div>
</div>
@endsection
