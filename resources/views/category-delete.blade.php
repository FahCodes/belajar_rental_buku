@extends('layouts.mainlayout')

@section('title', 'Delete Category')

@section('content')

    <h2>Apakah anda yakin akan menghapus kategori {{ $category->name }}</h2>
    <div class="mt-3">
        <a href="/category-destroy/{{ $category->slug }}" class="btn btn-danger me-1">Ya</a>
        <a href="/categories" class="btn btn-primary">Tidak</a>
    </div>

@endsection