<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('商品詳細') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container mx-auto">
                        <div class="flex justify-center">
                            <div class="w-full md:w-2/3">
                                <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                                    <div class="mb-4">
                                        <img src="{{ asset($item->photo_path) }}" alt="{{ $item->name }}"
                                            class="w-full h-auto max-h-60 object-contain rounded-lg">
                                    </div>
                                    <div class="text-center">
                                        <h3 class="text-2xl font-semibold">{{ $item->name }}</h3>
                                        <p class="text-gray-600">カテゴリー: {{ $item->category->name ?? '未設定' }}</p>
                                        <p class="text-gray-600">商品説明: {{ $item->description }}</p>
                                        <p class="text-gray-800 font-bold">価格: {{ number_format($item->price) }}円</p>
                                        <p class="text-gray-600">在庫数: {{ $item->stock }}</p>
                                    </div>
                                    @auth
                                        <div class="text-center mt-4">
                                            <form action="{{ route('cart.store', $item->id) }}" method="POST"
                                                class="inline-block">
                                                @csrf
                                                <label class="mr-2">数量:</label>
                                                <select name="amount" class="border rounded">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                                @error('amount')
                                                    <div class="text-red-500 mt-1">{{ $message }}</div>
                                                @enderror
                                                <button type="submit"
                                                    class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700 ml-2">カートに追加</button>
                                            </form>

                                            {{-- いいねボタン --}}
                                            @if ($item->favorites()->where('user_id', auth()->id())->exists())
                                                <form action="{{ route('items.unfavorite', $item->id) }}" method="POST"
                                                    class="inline-block ml-4 favorite-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-500 text-2xl focus:outline-none favorite-button">
                                                        <i class="fas fa-heart"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('items.favorite', $item->id) }}" method="POST"
                                                    class="inline-block ml-4 favorite-form">
                                                    @csrf
                                                    <button type="submit"
                                                        class="text-gray-500 text-2xl focus:outline-none favorite-button">
                                                        <i class="fas fa-heart"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    @else
                                        <p class="text-center mt-4">カートに追加するには<a href="{{ route('login') }}"
                                                class="text-blue-500 hover:underline">ログイン</a>してください。</p>
                                    @endauth

                                    {{-- コメント表示エリア --}}
                                    <div class="comments-area mt-8">
                                        <h3 class="text-xl font-semibold">コメント</h3>
                                        @foreach ($item->comments as $comment)
                                            <div class="bg-white p-4 rounded-lg shadow-md mb-4">
                                                <p><strong>{{ $comment->user->name }}</strong> -
                                                    {{ $comment->created_at->diffForHumans() }}</p>
                                                <p>{{ $comment->content }}</p>
                                                <p>評価: {{ $comment->rating }} / 10</p>
                                            </div>
                                        @endforeach

                                        {{-- コメント投稿フォーム --}}
                                        @auth
                                            <form action="{{ route('comments.store', $item->id) }}" method="POST">
                                                @csrf
                                                <div class="form-group mb-4">
                                                    <label for="content" class="block mb-2">コメント:</label>
                                                    <textarea class="form-control w-full border rounded py-2 px-3" name="content" id="content" rows="3"></textarea>
                                                </div>
                                                <div class="form-group mb-4">
                                                    <label for="rating" class="block mb-2">評価:</label>
                                                    <select class="form-control w-full border rounded py-2 px-3"
                                                        name="rating" id="rating">
                                                        @for ($i = 1; $i <= 10; $i++)
                                                            <option value="{{ $i }}">{{ $i }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <button type="submit"
                                                    class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700">コメントする</button>
                                            </form>
                                        @else
                                            <p>コメントするには<a href="{{ route('login') }}"
                                                    class="text-blue-500 hover:underline">ログイン</a>してください。</p>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript --}}
    <script>
        document.querySelectorAll('.favorite-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const url = this.action;
                const method = this.method;
                const button = this.querySelector('.favorite-button');
                const icon = button.querySelector('i');

                fetch(url, {
                    method: method,
                    body: new FormData(this),
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(response => {
                    if (response.ok) {
                        if (icon.classList.contains('text-gray-500')) {
                            icon.classList.remove('text-gray-500');
                            icon.classList.add('text-red-500');
                        } else {
                            icon.classList.remove('text-red-500');
                            icon.classList.add('text-gray-500');
                        }
                    } else {
                        alert('いいねの更新に失敗しました。');
                    }
                }).catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    </script>
</x-app-layout>
