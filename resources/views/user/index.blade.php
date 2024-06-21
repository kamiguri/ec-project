<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">

        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{route('search')}}" method="get">
                        @csrf
                        <button type="submit">検索</button>
                        <input type="text" name="keyword" value="">
                    </form>
                    @if(!isset($searches))
                    @foreach ($items as $item)
                    <ul>
                        <a href="{{route('show',['item_id' => $item->id])}}">
                        <li><img src="{{ asset('storage/' . $item->photo_path) }}" alt="{{ $item->name }}" class="img-fluid"></li>
                        <li>{{$item->name}}</li>
                        <li>在庫数：{{$item->stock}}　価格{{$item->price}}</li><br>
                        </a>
                    </ul>
                    @endforeach
                    @else
                    @foreach ($searches as $searche)
                    <ul>
                        <a href="{{route('show',['item_id' => $searche->id])}}">
                        <li><img src="{{ asset('storage/' . $searche->photo_path) }}" alt="{{ $searche->name }}" class="img-fluid"></li>
                        <li>{{$searche->name}}</li>
                        <li>在庫数：{{$searche->stock}}　価格{{$searche->price}}</li><br>
                        </a>
                    </ul>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
