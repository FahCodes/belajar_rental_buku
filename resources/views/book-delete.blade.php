@extends('layouts.mainlayout')

@section('title', 'Delete Book')

@section('content')

    <h2>Apakah kamu yakin akan menghapus book {{ $book->title }}</h2>
    <div class="mt-5">
        <a href="/book-destroy/{{ $book->slug }}" class="btn btn-danger">Delete</a>
        <a href="/books" class="btn btn-primary">Kembali</a>
    </div>

@endsection