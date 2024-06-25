<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('お気に入り') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @foreach ($items as $item)
                        @foreach ($myfavorite as $favorite)
                            @if ($item->id === $favorite->item_id)
                                <ul>
                                    <a href="{{route('show',['item_id' => $item->id])}}">
                                    <li><img src="{{ asset('storage/' . $item->photo_path) }}" alt="{{ $item->name }}" class="img-fluid"></li>
                                    <li>{{$item->name}}</li>
                                    <li>在庫数：{{$item->stock}}　価格{{$item->price}}</li>
                                    </a>
                                    <br>
                                </ul>
                            @endif
                        @endforeach
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
