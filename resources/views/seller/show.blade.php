<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            商品詳細
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
                                    <div class="card-header">{{ __('seller側の商品詳細画面です') }}</div>

                                    <div class="card-body">
                                        @if (session('status'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('status') }}
                                            </div>
                                        @endif
                                        {{-- 商品詳細 --}}
                                        <img src="{{ asset('storage/' . $item->photo_path) }}" alt="{{ $item->name }}" class="img-fluid">
                                        {{$item->name}}
                                        在庫数：{{$item->stock}}　価格{{$item->price}}<br>
                                        {{-- <a href="{{route('seller.edit',['item_id' => $item->id])}}"></a> --}}
                                    </div>
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
