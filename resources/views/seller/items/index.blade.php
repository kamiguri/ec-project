<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('商品一覧') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- ここから --}}
                    <div class="container mx-auto">
                        <div class="flex justify-center">
                            <div class="w-full md:w-3/4 lg:w-1/2">
                                <div class="bg-white shadow-md rounded-lg p-6">
                                    {{-- 商品名一覧 --}}
                                    <form action="{{ route('search') }}" method="get" class="mb-4">
                                        @csrf
                                        <button type="submit"
                                            class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700">検索</button>
                                        <input type="search" name="keyword" value=""
                                            class="form-input mt-2 block w-full" placeholder="商品名を入力">
                                        <select name="keyword1" id="keyword1" class="form-select mt-2 block w-full">
                                            <option value="null">カテゴリー未選択</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                    @if (!isset($searches))
                                        @foreach ($items as $item)
                                            <ul class="list-none mb-4">
                                                <a href="{{ route('seller.show', ['item_id' => $item->id]) }}"
                                                    class="block bg-gray-100 p-4 rounded-lg hover:bg-gray-200 transition duration-300">
                                                    <li><img src="{{ asset($item->photo_path) }}"
                                                            alt="{{ $item->name }}"
                                                            class="w-full h-auto mb-2 max-h-52 object-contain"></li>
                                                    <li class="font-semibold">{{ $item->name }}</li>
                                                    <li>在庫数：{{ $item->stock }}　価格{{ $item->price }}</li>
                                                    <li>
                                                        @foreach ($categories as $category)
                                                            @if ($category->id === $item->category_id)
                                                                カテゴリー：{{ $category->name }}
                                                            @endif
                                                        @endforeach
                                                    </li>
                                                </a>
                                            </ul>
                                        @endforeach
                                    @else
                                        @foreach ($searches as $search)
                                            <ul class="list-none mb-4">
                                                <a href="{{ route('seller.show', ['item_id' => $search->id]) }}"
                                                    class="block bg-gray-100 p-4 rounded-lg hover:bg-gray-200 transition duration-300">
                                                    <li><img src="{{ asset($search->photo_path) }}"
                                                            alt="{{ $search->name }}"
                                                            class="w-full h-auto mb-2 max-h-52 object-contain"></li>
                                                    <li class="font-semibold">{{ $search->name }}</li>
                                                    <li>在庫数：{{ $search->stock }}　価格{{ $search->price }}</li>
                                                    <li>
                                                        @foreach ($categories as $category)
                                                            @if ($category->id === $search->category_id)
                                                                カテゴリー：{{ $category->name }}
                                                            @endif
                                                        @endforeach
                                                    </li>
                                                </a>
                                            </ul>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- ここまで --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
