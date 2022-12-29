@extends('layouts.app')


@section('content')
    <div class="container mt-5">
    <form action="{{url('place-order')}}" method="POST">
                {{ csrf_field() }}
        <div class="row">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <h6> Basic Details </h6>
                        <hr>
                        <div class="row checkout-form">
                            <div class="col-md-6">
                                <label for="FirstName">Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Enter name">
                            </div>
                            <div class="col-md-6">
                                <label for="FirstName"> Email</label>
                                <input type="text" class="form-control" name="email" placeholder="Enter email">
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="FirstName"> Phone Number</label>
                                <input type="text" class="form-control" name="phone" placeholder="Enter phone number">
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="FirstName"> House Number</label>
                                <input type="text" class="form-control" name="house" placeholder="Enter house number">
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="FirstName"> City</label>
                                <input type="text" class="form-control" name="city" placeholder="Enter City">
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="FirstName"> Postal Code</label>
                                <input type="text" class="form-control"  name="postal" placeholder="Enter postal code">
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="FirstName"> Country</label>
                                <input type="text" class="form-control"  name="country" placeholder="Enter Country">
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h6> Order Details </h6>
                        <hr>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th> Name </th>
                                    <th> Quantity</th>
                                    <th> Price </th>

                                </tr>
                            </thead>
                            <tbody> 
                                @foreach ($cartitems as $item)
                                <tr>
                                    <td>{{$item->product->name}}</td>
                                    <td>{{$item->quantity}}</td>
                                    <td>{{$item->product->price * $item->quantity}} €</td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <hr>
                        <button type ="submit" class="btn btn-dark w-100">Place Order</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
@endsection