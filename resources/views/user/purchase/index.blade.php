
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            注文履歴
        </h2>
    </x-slot>

    <head>
        <!-- 他のhead内容 -->
        @vite(['resources/css/purchase_index.css'])
    </head>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('purchase.search') }}" method="get"
                        class="mb-4 flex flex-col md:flex-row items-center">
                        @csrf
                        <input type="search" name="keyword" value=""
                            class="form-input mt-2 md:mt-0 md:mr-2 w-full md:w-auto" placeholder="商品名を入力">
                        <button type="submit"
                            class="mt-2 md:mt-0 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700">検索</button>
                    </form>

                    @if (!isset($searches) && $orders->isEmpty())
                        <p class="text-center text-gray-500">まだ購入が行われていません</p>
                    @elseif(isset($searches) && $searches->isEmpty())
                        <p class="text-center text-gray-500">検索結果がありません</p>
                    @endif

                    @if (!isset($searches))
                        @foreach ($orders as $order)
                            <div class="border-t border-gray-200 py-4">
                                <h2 class="font-semibold text-lg mb-2">注文日時: {{ $order->created_at }}</h2>
                                <ul class="list-none mb-4">
                                    @foreach ($order->items as $item)
                                        <li class="bg-gray-100 p-4 rounded-lg mb-2">
                                            <img src="{{ asset($item->photo_path) }}" alt="{{ $item->name }}"
                                                class="w-full h-auto mb-2 max-h-52 object-contain">
                                            <a href="{{ route('show', ['item_id' => $item->id]) }}"
                                                class="text-blue-500 hover:underline">
                                                <h2 class="font-semibold">{{ $item->name }}</h2>
                                            </a>
                                            <p>カテゴリー: {{ $item->category->name }}</p>
                                            <p>合計金額: ¥{{ $item->total_price }}</p>
                                            <p>数量: {{ $item->pivot->amount }}</p>
                                            <p>価格：¥{{ $item->pivot->price }}</p>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    @else
                        @foreach ($searches as $search)
                            <div class="border-t border-gray-200 py-4">
                                <h2 class="font-semibold text-lg mb-2">注文日時: {{ $search->created_at }}</h2>
                                <ul class="list-none mb-4">
                                    @foreach ($search->items as $item)
                                        @if (str_contains($item->name, $keyword))
                                            <li class="bg-gray-100 p-4 rounded-lg mb-2">
                                                <img src="{{ asset($item->photo_path) }}" alt="{{ $item->name }}"
                                                    class="w-full h-auto mb-2 max-h-52 object-contain">
                                                <a href="{{ route('show', ['item_id' => $item->id]) }}"
                                                    class="text-blue-500 hover:underline">
                                                    <h2 class="font-semibold">{{ $item->name }}</h2>
                                                </a>
                                                <p>カテゴリー: {{ $item->category->name }}</p>
                                                <p>合計金額: ¥{{ $item->total_price }}</p>
                                                <p>数量: {{ $item->pivot->amount }}</p>
                                                <p>価格：¥{{ $item->pivot->price }}</p>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
