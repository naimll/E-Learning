@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Welcome {{ auth()->user()->name }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">b
                                {{ session('status') }}
                            </div>
                        @endif
                       <iframe width="100%" height="450px" src="{{  Config::get('settings.media_server_url') }}" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

