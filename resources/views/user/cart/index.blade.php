<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ショッピングカート
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="flex items-start gap-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($cartItems->isNotEmpty())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                        <div class="mb-5">
                            <p>合計 ¥
                                <span class="text-lg font-semibold">{{ number_format($totalPrice) }}</span>
                            </p>
                        </div>
                        <div class="mb-5">
                            <a href="{{ route('purchase.create') }}">
                                <x-primary-button class="w-full" type="button">
                                    {{ __('レジに進む') }}
                                </x-primary-button>
                            </a>
                        </div>
                    @error('amount')
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="grow bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 divide-y">
                    <p class="text-xl">商品一覧</p>
                    @foreach ($cartItems as $item)
                        <div class="my-5 py-5">
                            <a href="{{ route('show', $item->id) }}">
                                <p class="text-lg">{{ $item->name }}</p>
                                <div>
                                    <img src="{{ asset($item->photo_path) }}" alt="{{ $item->name }}" class="img-fluid"
                                        style="max-height: 200px;">
                                </div>
                            </a>
                            <p>¥<span class="text-lg font-semibold">{{ number_format($item->price) }}</span></p>
                            <div class="flex items-center">
                                <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="flex items-center">
                                        <x-input-label for="amount-input" :value="__('数量')" />

                                        <x-text-input id="amount-input" class="block ms-3 mt-1"
                                                        type="number"
                                                        name="amount"
                                                        value="{{ $item->pivot->amount }}"
                                                        required />
                                        <x-primary-button class="ms-3">
                                            {{ __('更新') }}
                                        </x-primary-button>
                                    </div>
                                </form>
                                <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <x-secondary-button class="ms-3" type="submit">
                                        {{ __('削除') }}
                                    </x-secondary-button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="grow bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p>カートに商品はありません</p>
                    <div class="my-3">
                        <a href="{{ route('index') }}">
                            <x-secondary-button>
                                {{ __('商品を探す')}}
                            </x-secondary-button>
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
