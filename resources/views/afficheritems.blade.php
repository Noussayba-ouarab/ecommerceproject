<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
@extends('layouts.app')

<!-- fashion section start -->
@section('content')
<div class='container' style='margin:80px;'>
<div class="row">
@if(session('cart'))
                           @foreach(session('cart') as $item)
                           <div class="col-lg-4 col-sm-4">
                              <div class="box_main">
                                 <h4 class="shirt_text">{{ $item['name'] }} </h4>
                                 <p class="price_text">{{$item['total_price'] }} <span style="color: #262626;">DH</span></p>
                                 <p class="price_text">you have {{$item['quantity'] }} items of
                                     {{($item['total_price'])/($item['quantity'])}} Dh for one item</p>
                               <a href="{{route('delete',['id' => $item['product_id']])}}">
                                 <i class="fas fa-trash-alt " id="delete-icon"></i>
</a>
                              </div>
                             
                           </div>
                           
                           @endforeach
                           @endif
@endsection
</div>
</div>
</body>
</html>