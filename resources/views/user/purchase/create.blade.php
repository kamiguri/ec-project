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
                        <div class="my-5">
                            <p class="text-lg font-bold">ご請求額: ¥
                                {{ number_format($totalPrice) }}
                            </p>
                        </div>
                        @foreach ($cartItems as $item)
                            <div class="mb-5 bg-gray">
                                <a href="{{ route('show', $item->id) }}">
                                    <p class="text-lg">{{ $item->name }}</p>
                                    <div>
                                        <img src="{{ asset($item->photo_path) }}" alt="{{ $item->name }}" class="img-fluid"
                                            style="max-height: 100px;">
                                    </div>
                                </a>
                                <p>¥<span class="text-md font-semibold">{{ number_format($item->price) }}</span></p>
                                <p>数量: {{ $item->pivot->amount }}</p>
                            </div>
                        @endforeach
                        <div class="my-5">
                            <a href="{{ route('payment.checkout') }}">
                                <x-primary-button>
                                    {{ __('支払いに進む') }}
                                </x-primary-button>
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
