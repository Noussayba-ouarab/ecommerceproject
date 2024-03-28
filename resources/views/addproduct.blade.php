<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add product</title>
    @include('head') 
</head>
<body>
    <div class='container' style='width:400px; height:900px;'>
<div class="max-w-md mx-auto">
  <div class="bg-white shadow-md rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-4">Add Poste</h2>
    <form id="add-poste" method="post" action="{{ route('addproduct') }}" enctype="multipart/form-data" >
    @csrf
      <div class="mb-4">
        <label for="comment" class="block text-sm font-medium text-gray-700">Description</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description" 
        placeholder="add description...." >
  </textarea>
      </div>
      <div class="form-group">
                <label for="productName">Product Name</label>
                <input type="text" class="form-control" id="productName" name="name" placeholder="Enter product name" required>
            </div>
            <div class="form-group">
                <label for="productName">Price</label>
                <input type="text" class="form-control" id="productName" name="prix" placeholder="Enter product name" required>
            </div>
            <div class="form-group">
                <label for="productName">Size</label>
                <input type="text" class="form-control" id="productName" name="size" placeholder="Enter product name" required>
            </div>
            <div class="form-group">
                <label for="productName">Type</label>
                <input type="text" class="form-control" id="productName" name="type" placeholder="Enter product name" required>
            </div> 

      <div class="mb-4">
        <label for="file" class="block text-sm font-medium text-gray-700">Upload File</label>
        <input type="file"  name="image" class="mt-1 block w-full rounded-md border-gray-300">
      </div>
      <div class="flex items-center justify-between">
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-black font-semibold py-2 px-4 rounded-md focus:outline-none focus:shadow-outline">
          Add Product
        </button>
      </div>
    </form>
  </div>
</div>
</div>

</body>
</html>