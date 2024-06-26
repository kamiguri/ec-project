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
                                    @foreach ($items as $item)
                                    <ul>
                                        <a href="{{route('seller.show',['item_id' => $item->id])}}">
                                        <li><img src="{{ asset($item->photo_path) }}" alt="{{ $item->name }}" class="img-fluid" style="width: 150px; height: 150px;"></li>
                                        <li>{{$item->name}}</li>
                                        <li>在庫数：{{$item->stock}}　価格{{$item->price}}</li><br>
                                        </a>
                                    </ul>
                                    @endforeach
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
