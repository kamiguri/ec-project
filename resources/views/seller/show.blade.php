<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('商品詳細') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container mx-auto">
                        <div class="flex justify-center">
                            <div class="w-full md:w-2/3">
                                <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                                    <div class="mb-4">
                                        <img src="{{ asset($item->photo_path) }}" alt="{{ $item->name }}"
                                            class="w-full h-auto max-h-60 object-contain rounded-lg">
                                    </div>
                                    <div class="text-center">
                                        <h3 class="text-2xl font-semibold">{{ $item->name }}</h3>
                                        <p class="text-gray-600">カテゴリー: {{ $item->category->name ?? '未設定' }}</p>
                                        <p class="text-gray-600">商品説明: {{ $item->description }}</p>
                                        <p class="text-gray-800 font-bold">価格: {{ number_format($item->price) }}円</p>
                                        <p class="text-gray-600">在庫数: {{ $item->stock }}</p>
                                    </div>
                                    <div class="flex justify-center mt-4">
                                        <a href="{{ route('seller.edit', ['item_id' => $item->id]) }}"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">編集</a>
                                        <a href="{{ route('seller.stock', ['item_id' => $item->id]) }}"
                                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">在庫の更新</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
