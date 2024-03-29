<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>afficher produit</title>
    @include('head')


</head>

<body>
    <div class='container'>
        <section class="py-5" style='margin:50px;'>
            <div class="container px-4 px-lg-5 my-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6"><img src="{{asset('produits/'.$products->image)}}" /></div>
                    <div class="col-md-6">
                        <div class="small mb-1">{{$products->name}}</div>
                        <h1 class="display-5 fw-bolder">{{$products->size}}</h1>
                        <div class="fs-5 mb-5">

                            <span id="productPrice">{{$products->prix}} DH</span>
                        </div>
                        <p class="lead">{{$products->description}}</p>
                        <div class="d-flex">
                            <button class="form-control text-center me-3" style="max-width: 3rem" onclick="remove()">-</button>
                            <input class="form-control text-center me-3" id="inputQuantity" type="num" name='quantite' value="1" style="max-width: 3rem" />
                            <button class="form-control text-center me-3" style="max-width: 3rem" id="inputprix2" onclick="add()">+</button>
                            <form id="add-poste" method="post" action="{{ secure_url('addcommande',['id'=>$products->id])}}">
                                @csrf
                                <input type="hidden" name="prix" id='hiddenprix'>
                                <input type="hidden" name="quantite" id="hiddenQuantity" style="max-width: 3rem">
                                <input type="hidden" name="item" id="hiddenItem" style="max-width: 3rem">
                                <button class="btn btn-outline-dark flex-shrink-0" type="submit" onclick="updateHiddenField()">
                                    <i class="bi-cart-fill me-1"></i>
                                    Add to cart
                                </button>
                            </form>
                            <form action="{{route('payment')}}" method="POST">
                                @csrf
                                {{-- {!! QrCode::size(200)->generate(url('/payement')) !!} --}}

                                <button type="submit" class="btn btn-primary">Payer</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</body>

</html>
<script>
    var d = <?php echo $products->prix; ?>;

    function updatePrice(value) {
        var productPrice = document.getElementById('productPrice');
        return productPrice.innerText = value * d;
    }

    function add() {

        var price = document.getElementById('price');
        var inputQuantity = document.getElementById('inputQuantity');
        var currentValue = parseInt(inputQuantity.value);
        inputQuantity.value = currentValue + 1;
        console.log(inputQuantity.value);
        updatePrice(currentValue + 1);
        var itemCountSpan = document.getElementById('item-count');
        console.log(itemCountSpan);
        var currentCount = parseInt(itemCountSpan.textContent);
        itemCountSpan.textContent = currentCount + 1;
        console.log(session(sum > 0));
        if (session(sum > 0) || !empty(itemCountSpan.textContent)) {
            document.getElementById('item-count').style.display = 'inline';
        } else {
            document.getElementById('item-count').style.display = 'none';
        }
    };

    function remove() {

        var inputQuantity = document.getElementById('inputQuantity');
        var currentValue = parseInt(inputQuantity.value);
        if (currentValue > 1) {
            inputQuantity.value = currentValue - 1;
            updatePrice(currentValue - 1);

            var itemCountSpan = document.getElementById('item-count');
            var currentCount = parseInt(itemCountSpan.textContent);
            itemCountSpan.textContent = currentCount - 1;

            if (session(sum > 0) || !empty(itemCountSpan.textContent)) {
                document.getElementById('item-count').style.display = 'inline';
            } else {
                document.getElementById('item-count').style.display = 'none';
            }
        }
    }

    function updateHiddenField() {
        var inputQuantity = document.getElementById('inputQuantity');
        var hiddenInput = document.getElementById('hiddenQuantity');
        var inputprix = updatePrice(inputQuantity.value);
        var hiddenprix = document.getElementById('hiddenprix');
        hiddenInput.value = inputQuantity.value;
        hiddenprix.value = inputprix;
        var itemCountSpan = document.getElementById('item-count');
        var currentCount = parseInt(itemCountSpan.textContent);
        var hiddenitemCountSpan = document.getElementById('hiddenItem');
        hiddenitemCountSpan.value = currentCount;
        console.log(hiddenitemCountSpan.value);
    }

    
</script>