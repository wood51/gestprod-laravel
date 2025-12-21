@extends('layout.app')

@section('content')
    <form method="POST" action="/pa/import" enctype="multipart/form-data">
        @csrf
        <input class="input" type="file" name="pdf" accept="application/pdf" required>
        <button class="btn" type="submit">Upload + Parse</button>
    </form>

    @if (session('status'))
        <p>{{ session('status') }}</p>
    @endif
@endsection
