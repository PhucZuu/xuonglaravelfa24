@extends('master')

@section('title')
    Thêm mới khách hàng
@endsection

@section('content')
    <h1>Thêm mới khách hàng</h1>

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
        <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3 row">
                <label for="name" class="col-4 col-form-label">Name</label>
                <div class="col-8">
                    <input type="text" value="{{ old('name') }}" class="form-control" name="name" id="name" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="address" class="col-4 col-form-label">Address</label>
                <div class="col-8">
                    <input type="text" value="{{ old('address') }}" class="form-control" name="address" id="address" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="phone" class="col-4 col-form-label">Phone</label>
                <div class="col-8">
                    <input type="tel" value="{{ old('phone') }}" class="form-control" name="phone" id="phone" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="email" class="col-4 col-form-label">Email</label>
                <div class="col-8">
                    <input type="email" value="{{ old('email') }}" class="form-control" name="email" id="email" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="is_active" class="col-4 col-form-label">Active</label>
                <div class="col-8">
                    <input type="checkbox" value="1" class="form-checkbox" name="is_actice" id="is_actice" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="avatar" class="col-4 col-form-label">Avatar</label>
                <div class="col-8">
                    <input type="file" class="form-control" name="avatar" id="avatar" />
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
