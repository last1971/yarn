@extends('layouts.default')

<div>
    <h2>ОПИСАНИЕ</h2>
    <h1>{{ $category->name }}</h1>
    <p>{{ $category->description }}</p>
    <img src="{{ '/picture/' . $category->slug . '/' . $category->id . '/' . ( $category->picture ? $category->picture->file : '1') }}" alt="{{ $category->name }}"/>
</div>

<div>
    <h2>ПОДКАТЕГОРИИ</h2>
    @include('subcategories', ['categories' => $category->children])
</div>
<div>
    <h2>ПРОДУКТЫ</h2>
    @include('subproducts', ['products' => $category->products])
</div>
