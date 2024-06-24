<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <x-navigation-link title="タイトル" :skillId="1"/>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3>{{ __("注文履歴画面") }}</h3><br>
                    @foreach ($orders as $order)
                    注文日時:{{$order->created_at}}
                        <ul>
                            @foreach ($order->items as $item)
                                <li>
                                    <img src="{{ $item->photo_path }}" alt="{{ $item->name }}" style="width: 100px; height: 100px;">
                                    <h3>{{ $item->name }}</h3>
                                    <p>カテゴリー: {{ $item->category->name }}</p>
                                    <p>価格: ¥{{ $item->total_price }}</p>
                                    <p>数量: {{ $item->pivot->amount }}</p>
                                </li>
                            @endforeach
                        </ul>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
