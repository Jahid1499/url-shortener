@extends('layouts.app')
@section('title', 'Create short url')
@section('content')
    <div class="container mt-5">
        @if(session('shortened_url'))
            <div class="alert alert-success" role="alert">
                Original URL: {{ session('original_url') }}<br>
                Shortened URL: <a target="_blank" href="{{ session('shortened_url') }}">{{ session('shortened_url') }}</a>
                <br/>
                <br/>
                <a href="{{route('home')}}">Back to home?</a>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('url.shorten') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="url" class="form-label"><h4>Enter URL to Shorten</h4></label>
                <input placeholder="Please enter valid url. Ex. https://myurl.com" type="url" class="form-control" id="url" value="{{old('url')}}" name="url" required>
            </div>
            <button type="submit" class="btn btn-primary">Shorten URL</button>
        </form>
    </div>
@endsection
