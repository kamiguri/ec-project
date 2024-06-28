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
                    @if ($items->isEmpty() || $myfavorite->isEmpty())
                        <p class="text-center text-gray-500">お気に入りの商品はまだありません</p>
                    @else
                        @foreach ($items as $item)
                            @foreach ($myfavorite as $favorite)
                                @if ($item->id === $favorite->item_id)
                                    <div class="mb-4 border-b border-gray-200 pb-4">
                                        <a href="{{ route('show', ['item_id' => $item->id]) }}"
                                            class="block bg-gray-100 p-4 rounded-lg hover:bg-gray-200 transition duration-300">
                                            <img src="{{ asset($item->photo_path) }}" alt="{{ $item->name }}"
                                                class="w-full h-auto mb-2 max-h-52 object-contain">
                                            <h2 class="font-semibold text-lg">{{ $item->name }}</h2>
                                            <p>在庫数：{{ $item->stock }}　価格：¥{{ $item->price }}</p>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
