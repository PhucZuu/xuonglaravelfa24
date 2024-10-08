@extends('master')

@section('title')
    Cập nhật khách hàng: {{$customer->name}}
@endsection

@section('content')
    <h1>Cập nhật khách hàng: {{$customer->name}}</h1>

    @if ($errors->any())
        <div class="alert alert-warning">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>$error</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container">
        <form action="{{ route('customers.update', $customer) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3 row">
                <label for="name" class="col-4 col-form-label">Name</label>
                <div class="col-8">
                    <input type="text" value="{{ $customer->name) }}" class="form-control" name="name" id="name" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="address" class="col-4 col-form-label">Address</label>
                <div class="col-8">
                    <input type="text" value="{{ $customer->address) }}" class="form-control" name="address" id="address" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="phone" class="col-4 col-form-label">Phone</label>
                <div class="col-8">
                    <input type="tel" value="{{ $customer->phone) }}" class="form-control" name="phone" id="phone" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="email" class="col-4 col-form-label">Email</label>
                <div class="col-8">
                    <input type="email" value="{{ $customer->email) }}" class="form-control" name="email" id="email" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="is_active" class="col-4 col-form-label">Active</label>
                <div class="col-8">
                    <input type="checkbox" value="1" 
                    @checked($customer->is_active) 
                    class="form-checkbox" name="is_actice" id="is_actice" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="avatar" class="col-4 col-form-label">Avatar</label>
                <div class="col-8">
                    <input type="file" class="form-control" name="avatar" id="avatar" />
                    @if ($customer->avatar)
                        <img width="100px" src="{{ Storage::url($customer->avatar) }}" alt="">
                    @endif
                </div>
            </div>

            <div class="mb-3 row">
                <div class="offset-sm-4 col-sm-8">
                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
