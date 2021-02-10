@extends('layouts.default')

<div>
    <h1>{{ $product->name }}</h1>
    <p>{{ $product->description }}</p>
    <img src="{{ '/picture/' . $product->slug . '/' . $product->id . '/' . ( $product->picture ? $product->picture->file : '1') }}" alt="{{ $product->name }}" />
    <div>
        <h2>Цены</h2>
        @foreach($product->prices as $price)
            <span>от</span>{{ $price->min }}<span>шт.</span>
            <span>цена</span>{{ $price->price }}<span>руб.</span>
        @endforeach
        <h2>Наличие</h2>
        @foreach($product->warehouseBalances as $warehouseBalance)
            {{ $warehouseBalance->balance }}<span>шт.</span>
            <span>:</span>{{  $warehouseBalance->warehouse->name }}
        @endforeach
        <h2>Параметры</h2>
        @foreach($product->parameterValues as $parameterValue)
            {{ $parameterValue->parameterName->name }}<span>:</span>
            @if($parameterValue->string_value)
                {{ $parameterValue->string_value }}
            @endif
            @if($parameterValue->numeric_value)
                {{ round($parameterValue->numeric_value, $parameterValue->fraction) }}
                {{ $parameterValue->parameterUnit->abbreviation }}
            @endif
        @endforeach
    </div>
</div>
