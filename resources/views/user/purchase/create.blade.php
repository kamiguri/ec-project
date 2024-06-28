<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            注文確認
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($cartItems->isNotEmpty())
                        <div>
                            <a href="{{ route('cart.index') }}">
                                <x-secondary-button>
                                    {{ __('カートに戻る') }}
                                </x-secondary-button>
                            </a>
                        </div>
                        <h1>注文の確認</h1>
                        <div>
                            合計金額: ¥{{ number_format($totalPrice) }}
                        </div>
                        @foreach ($cartItems as $item)
                            <div>
                                商品名: {{ $item->name }}
                                金額: ¥{{ number_format($item->price) }}
                                数量: {{ $item->pivot->amount }}
                            </div>
                        @endforeach
                        <div>
                            <a href="{{ route('payment.checkout') }}">
                                <button>支払いに進む</button>
                            </a>
                        </div>
                    @else
                        <div>
                            カートに商品が入っていません。
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
