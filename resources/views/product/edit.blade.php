<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit products</title>
</head>
<body>
<h1>This is edit page</h1>
<form action="{{route('product.update', $product->id)}}" method="post">
    @csrf
    @method('put')
    <label for="name">
        <input id="name" name="name" value="{{$product->name}}" type="text" />
    </label>
    <label for="price">
        <input id="price" name="price" value="{{$product->price}}" type="text" />
    </label>

</form>
</body>
</html>
