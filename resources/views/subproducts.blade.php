    @foreach($products as $product)
        <a href="{{ route('product', ['product' => $product->id, 'slug' => $product->slug ]) }}">
            <h1>{{ $product->name }}</h1>
            <p>{{ $product->description }}</p>
            <img src="{{ '/picture/' . $product->slug . '/' . $product->id . '/' . ( $product->picture ? $product->picture->file : '1') }}" alt="{{ $product->name }}"/>
        </a>
    @endforeach
