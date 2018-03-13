@extends('layouts.app') @section('title', 'Cart') @section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-white border">
            <li class="breadcrumb-item">
                <a href="{{ route('home.index') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('cart.index') }}">Shopping Cart</a>
            </li>
        </ol>
    </nav>

    @if(Session::has('success'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
    @endif

    <div class="row">
        <div class="col-md-9">
            <div class="mt-4">
                @if(Cart::count() > 0)
                <h2 class="mb-5">{{ Cart::count() }} item(s) in Shopping Cart</h2>

                <table class="table">
                    <tbody>
                        @foreach(Cart::content() as $cartItem)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td class="w-25">
                                <a href="{{ route('shop.show', $cartItem->model->slug) }}">
                                    <img class="img-fluid" src="{{ asset('img/products/' . $cartItem->model->slug . '.jpg') }}" alt="">
                                </a>
                            </td>
                            <td>{{ $cartItem->model->name }}</td>
                            <td>
                                <form action="{{ route('cart.destroy', $cartItem->rowId) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-link btn-sm">Remove X</button>
                                </form>
                            </td>
                            <td>
                                <select class="custom-select" id="inlineFormCustomSelect">
                                    <option value="1" selected>1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </td>
                            <td>
                                <h5>{{ $cartItem->model->presentPrice() }}</h5>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>

                <div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt accusantium iusto
                                            eligendi quae consectetur voluptate hic ratione, minima error totam.</p>
                                    </div>
                                    <div class="col-md-4">
                                        @php
                                        function presentPrice($price){
                                            // Format $price to ms_my currency
                                            setlocale(LC_MONETARY, 'ms_MY');
                                            return money_format('%i', $price) . "\n";
                                        }
                                        @endphp
                                        <p>Subtotal: <span class="float-right"> {{ presentPrice(Cart::subtotal()) }}</span></p>
                                        <p>Tax: (6%) <span class="float-right"> {{ presentPrice(Cart::tax()) }}</span></p>
                                        <p class="font-weight-bold lead">Total: <span class="float-right"> {{ presentPrice(Cart::total()) }}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg">Continue Shopping..</a>
                            <a href="" class="btn btn-warning btn-lg float-right">Go to Checkout</a>
                        </div>
                    </div>

                @else
                <h3>No items in your cart..</h3>
                <a href="{{ route('shop.index') }}" class="btn btn-warning btn-lg mt-3">Continue Shopping!</a>
                @endif

            </div>
        </div>
    </div>
</div>
<div class="jumbotron jumbotron-fluid mt-5 mb-0">
    <div class="container">
        <h4 class="mb-4">You might also like..</h4>
        <div class="row">
            @foreach($suggested_products as $suggested_product)
            <div class="col-md-3">
                <div class="card">
                    <a href="{{ route('shop.show', $suggested_product->slug) }}">
                        <img class="card-img-top" src="{{ asset('img/products/' . $suggested_product->slug . '.jpg') }}" alt="">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">{{ $suggested_product->name }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $suggested_product->presentPrice() }}</h6>
                        <p class="card-text">{{ $suggested_product->details }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection