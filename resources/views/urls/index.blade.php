@extends('layouts.app')

@section('title', 'URL Shortener')

@section('content')
    <div class="container mt-2">

        @if(session('success'))
            <div class="alert alert-success" role="alert">
                <p>{{session('success')}}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger" role="alert">
                <p>{{session('error')}}</p>
            </div>
        @endif

        <div class="mb-3">
            <div class="card-header">
                <a href="{{route('url.create')}}" role="button"><button type="button" class="btn btn-primary">Create new url</button></a>
            </div>
        </div>
        <h2>Your Shortened URLs</h2>
        <table class="table mt-3 table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Original URL</th>
                    <th scope="col">Shortened URL</th>
                    <th scope="col">Clicks</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
            @forelse($urls as $key => $url)
                @php
                    $sl = $key + 1;
                @endphp
                <tr>
                    <th scope="row">{{ $sl }}</th>
                    <td>{{ $url->original_url }}</td>
                    <td><a id="shortened-url-{{ $sl }}" href="{{ route('url.redirect', ['code' => $url->code]) }}" target="_blank">{{ route('url.redirect', ['code' => $url->code]) }}</a></td>
                    <td>{{ $url->clicks }}</td>
                    <td class="d-flex align-items-center">
                        <button class="btn btn-primary copy-button mr-2" data-target="shortened-url-{{ $sl }}">
                            <i class="bi bi-clipboard"></i>
                        </button>

                        <form action="{{route('url.delete', $url->id)}}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No shortened URLs yet.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const copyButtons = document.querySelectorAll('.copy-button');
            copyButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const targetId = this.getAttribute('data-target');
                    const content = document.querySelector(`#${targetId}`)
                    const cb = navigator.clipboard;
                    cb.writeText(content.href).then(()=>{alert("Short url copied!!")})
                });
            });
        });
    </script>
@endsection
