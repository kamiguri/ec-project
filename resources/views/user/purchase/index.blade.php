<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            注文履歴
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action ="{{route("purchase.search")}}" method="get">
                    @csrf
                    <button type="submit">検索</button>
                    <input type="search" name="keyword" value="">

                    </form>
                    @if(!isset($searches))
                    @foreach ($orders as $order)
                    注文日時:{{$order->created_at}}
                        <ul>
                            @foreach ($order->items as $item)
                                <li>
                                    <img src="{{ $item->photo_path }}" alt="{{ $item->name }}" style="height: 100px;">
                                    <a href="{{route('show',['item_id' => $item->id])}}"><h2>{{ $item->name }}</h2></a>
                                    <p>カテゴリー: {{ $item->category->name }}</p>
                                    <p>合計金額: ¥{{ $item->total_price }}</p>
                                    <p>数量: {{ $item->pivot->amount }}</p>
                                    <p>価格：¥{{$item->pivot->price}}</p>
                                </li>

                            @endforeach
                        </ul>
                    @endforeach
                    @else

                        <ul>
                          @foreach ($searches as $searche)
                          注文日時:{{$searche->created_at}}
                            @foreach($searche->items as $item)
                             @if(str_contains($item->name,$keyword))

                                <li>
                                    <img src="{{ asset($item->photo_path) }}" alt="{{ $item->name }}" style="max-height: 200px;">
                                    <a href="{{route('show',['item_id' => $item->id])}}"><h2>{{ $item->name }}</h2></a>
                                    <p>カテゴリー: {{ $item->category->name }}</p>
                                    <p>合計金額: ¥{{ $item->total_price }}</p>
                                    <p>数量: {{ $item->pivot->amount }}</p>
                                    <p>価格：¥{{$item->pivot->price}}</p>
                                </li>

                             @endif
                                @endforeach
                            @endforeach
                        </ul>

                    @endif


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
