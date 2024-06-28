<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('在庫登録画面') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-lg font-semibold mb-2">商品名: {{ $item->name }}</h2>
                    <p class="mb-4">現在の在庫数: {{ $item->stock }}</p>

                    <form action="/seller/item/{{ $item->id }}/stock" method="post" class="space-y-4">
                        @csrf
                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700">新しい在庫数:</label>
                            <input type="number" name="stock" id="stock"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">更新する</button>
                        </div>
                    </form>
                    <a href="{{ route('seller.items.index') }}" class="mt-4 inline-block underline">商品一覧へ</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
