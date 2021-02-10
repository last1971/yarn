    @foreach($categories as $category)
        <a href="{{ route('category', ['category' => $category->id, 'slug' => $category->slug ]) }}">
            <h1>{{ $category->name }}</h1>
            <p>{{ $category->description }}</p>
            <img src="{{ '/picture/' . $category->slug . '/' . $category->id . '/' . ( $category->picture ? $category->picture->file : '1') }}" alt="{{ $category->name }}"/>
        </a>
    @endforeach
