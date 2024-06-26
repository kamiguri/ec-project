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
                    <h2>商品名:{{$item->name}}</h2>
                    <h2>在庫数:{{$item->stock}}</h2>
                    <form action="/seller/item/{{$item->id}}/stock" method="post">
                    @csrf
                    <h3>在庫数:<input type="text" name="stock" value=""></h3>
                    <div>
                        <button type="submit">更新する</button>
                    </div>
                    </form>
                    <a href="{{ route('seller.items.index') }}">商品一覧へ</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
