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
                    {{--  ここから  --}}
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="card">
                                    {{-- 商品名一覧 --}}
                                    <form action="{{route('search')}}" method="get">
                                        @csrf
                                        <button type="submit">検索</button>
                                        <input type="search" name="keyword" value="">
                                        <select name="keyword1" id="keyword1">
                                            <option value="null">カテゴリー未選択</option>
                                            @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                    @if(!isset($searches))
                                    @foreach ($items as $item)
                                    <ul>
                                        <a href="{{route('seller.show',['item_id' => $item->id])}}">
                                        <li><img src="{{ asset($item->photo_path) }}" alt="{{ $item->name }}" class="img-fluid" style="max-height: 200px;"></li>
                                        <li>{{$item->name}}</li>
                                        <li>在庫数：{{$item->stock}}　価格{{$item->price}}</li>
                                        <li>
                                            @foreach ($categories as $category)
                                            @if ($category->id === $item->category_id)
                                            カテゴリー：{{$category->name}}
                                            @endif
                                            @endforeach
                                        </li><br>
                                        </a>
                                    </ul>
                                    @endforeach
                                    @else
                                    @foreach ($searches as $searche)
                                    <ul>
                                        <a href="{{route('seller.show',['item_id' => $searche->id])}}">
                                        <li><img src="{{ asset($searche->photo_path) }}" alt="{{ $searche->name }}" class="img-fluid" style="max-height: 200px;"></li>
                                        <li>{{$searche->name}}</li>
                                        <li>在庫数：{{$searche->stock}}　価格{{$searche->price}}</li>
                                        <li>
                                            @foreach ($categories as $category)
                                            @if ($category->id === $searche->category_id)
                                            カテゴリー：{{$category->name}}
                                            @endif
                                            @endforeach
                                        </li><br>
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
