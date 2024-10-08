@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (session('unauthorized'))
                        <div class="alert alert-warning" role="alert">
                            {{ session('unauthorized') }}
                        </div>
                    @endif

                    @if (session('FPIwarning'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('FPIwarning') }}
                        </div>
                    @endif

                    {{ __('Welcome to my Website !!!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
