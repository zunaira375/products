@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Mobiles</div>
                <div class="card-body">
                   {{-- //{{$customer}} --}}
                   <h1>Name: {{$customer->name}}</h1>
                   <h1>phone: {{$customer->phone_number}}</h1>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
