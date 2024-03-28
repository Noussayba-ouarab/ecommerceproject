<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produit femme</title>
    @include('head')
</head>
<body>
<div class="fashion_section">
         <div id="main_slider" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
               <div class="carousel-item active">
                  <div class="container">
                     <h1 class="fashion_taital"> kids Fashion</h1>
                     <div class="fashion_section_2">
                        <div class="row">
                            @if($products)
                            @foreach($products as $product)
                           <div class="col-lg-4 col-sm-4">
                              <div class="box_main">
                                 <h4 class="shirt_text">{{$product->name}}</h4>
                                 <p class="price_text">{{$product->prix}} <span style="color: #262626;">DH</span></p>
                                 <div class="tshirt_img">
                                    <img src="{{'produits/'.$product->image}}"></div>
                                 <div class="btn_main">
                                    <div class="buy_bt"><a href="#">Buy Now</a></div>
                                    <div class="seemore_bt"><a href="#">See More</a></div>
                                 </div>
                              </div>
                           </div>
                           @endforeach
                           @endif

                        </div>
                     </div>
                  </div>
               </div>
               
               

                           
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <a class="carousel-control-prev" href="#main_slider" role="button" data-slide="prev">
            <i class="fa fa-angle-left"></i>
            </a>
            <a class="carousel-control-next" href="#main_slider" role="button" data-slide="next">
            <i class="fa fa-angle-right"></i>
            </a>
         </div>
      </div>
    
</body>
</html>