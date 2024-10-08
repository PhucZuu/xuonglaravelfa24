@extends('master')

@section('title')
    Danh sách khách hàng
@endsection

@section('content')
    <h1>Danh sách khách hàng</h1>

    
    <a class="btn btn-success" href="{{ route('customers.create') }}" role="button">Create</a>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-borderless align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>ADDRESS</th>
                    <th>AVATAR</th>
                    <th>PHONE</th>
                    <th>EMAIL</th>
                    <th>ACTIVE</th>
                    <th>CREATED AT</th>
                    <th>UPDATED AT</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($data as $customer)
                    <tr class="">
                        <td scope="row">{{ $customer->id }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->address }}</td>
                        <td>
                            @if ($customer->avatar)
                                <img width="100px" src="{{ Storage::url($customer->avatar) }}" alt="">
                            @else
                                <span class="badge bg-warning">Null</span>
                            @endif
                        </td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>
                            @if ($customer->is_active)
                                <span class="badge bg-success">Yes</span>
                            @else
                                <span class="badge bg-danger">No</span>
                            @endif
                        </td>
                        <td>{{ $customer->created_at }}</td>
                        <td>{{ $customer->updated_at }}</td>
                        <td>

                            <a class="btn btn-info" href="{{ route('customers.show', $customer) }}" role="button">Show</a>
                            <a class="btn btn-primary" href="{{ route('customers.edit', $customer) }}" role="button">Edit</a>

                            <form action="{{ route('customers.destroy', $customer) }}" method="post">
                                @csrf
                                @method('DELETE')

                                <button type="submit" onclick="return confirm('Are u sure??')" class="btn btn-warning">Trash</button>
                            </form>

                            <form action="{{ route('customers.forceDestroy', $customer) }}" method="post">
                                @csrf
                                @method('DELETE')

                                <button type="submit" onclick="return confirm('Are u sure🤨??')" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{$data->links()}}
    </div>
@endsection
