<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>Hello bangladesh</h1>
@if(auth()->user()->is_admin)
    <a href="{{route('product.create')}}">Add new product</a>
@endif

@if(auth()->user()->is_admin)
    <a href="{{route('product.edit', 1)}}">Edit product</a>
@endif

@if(auth()->user()->is_admin)
    <a href="{{route('product.destroy', 1)}}">Delete product</a>
@endif
</body>
</html>
