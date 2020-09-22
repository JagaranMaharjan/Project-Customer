@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-md-3">
            @if(session('success'))
                <div class="alert alert-success">
                    {{session('success')}}
                </div>
            @endif
            <center><h4>Add Customer Info</h4></center>
            <hr>
            <form action="{{route('add')}}" method="post" enctype="multipart/form-data">
                <!--to send data securely csrf_field method is called-->
                {{csrf_field()}}
                <div class="form-group">
                    <label for="customerName">Name</label>
                    <input type="text" name="customerName" id="customerName" class="form-control", value="{{old('customerName')}}">
                    <div>
                        <p style="color: red;">{{$errors->first('customerName')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" class="form-control", value="{{old('address')}}">
                    <div>
                        <p style="color: red;">{{$errors->first('address')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="organization">Organization</label>
                    <input type="text" name="organization" id="organization" class="form-control", value="{{old('organization')}}">
                    <div>
                        <p style="color: red;">{{$errors->first('organization')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" class="form-control", value="{{old('email')}}">
                    <div>
                        <p style="color: red;">{{$errors->first('email')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="mobile">Phone</label>
                    <input type="text" name="mobile" id="phone" class="form-control", value="{{old('mobile')}}">
                    <div>
                        <p style="color: red;">{{$errors->first('mobile')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="image">Choose Photo</label>
                    <input type="file" name="image" id="image" class="form-control", value="{{old('image')}}">
                    <div>
                        <p style="color: red;">{{$errors->first('image')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary">Register</button>
                </div>

            </form>
        </div>
        <div class="col-md-9">
            <center><h4>Customer Data</h4></center>
            <hr>
            <table class="table table-hover">
                <tr>
                    <th>S.No.</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Organization</th>
                    <th>E-mail</th>
                    <th>Phone</th>
                    <th>Image</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
                @foreach($customerData as $key=>$customerDetail)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$customerDetail->customerName}}</td>
                        <td>{{$customerDetail->address}}</td>
                        <td>{{$customerDetail->organization}}</td>
                        <td>{{$customerDetail->email}}</td>
                        <td>{{$customerDetail->mobile}}</td>
                        <td><img src="{{url("lib/images/".$customerDetail->image)}}", width="50px", height="50px"></td>
                        <td>{{$customerDetail->created_at->DiffForHumans()}}</td>
                        <td>
                            <button class="btn btn-danger btn-xs"><a href="{{'delete'.'/'.$customerDetail->id}}">Delete</a></button>
                            <button class="btn btn-warning btn-xs"><a href="{{'edit'.'/'.$customerDetail->id}}">Edit</a></button>
                        </td>
                    </tr>
                @endforeach
            </table>
            <center>{{$customerData->links()}}</center>
        </div>
    </div>
@endsection