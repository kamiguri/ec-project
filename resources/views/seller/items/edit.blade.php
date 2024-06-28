<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('商品編集') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container mx-auto">
                        <form action="/seller/item/{{ $item->id }}/edit" method="post" enctype="multipart/form-data"
                            class="space-y-6">
                            @csrf
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">商品名</label>
                                <input type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    id="name" name="name" value="{{ old('name', $item->name) }}">
                            </div>

                            <div>
                                <label for="photo_path" class="block text-sm font-medium text-gray-700">写真</label>
                                @if ($item->photo_path)
                                    <div class="mt-2">
                                        <img src="{{ asset($item->photo_path) }}" alt="Current Photo"
                                            class="rounded-lg shadow-md h-64 object-cover">
                                    </div>
                                @endif
                                <input type="file"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    id="photo_path" name="photo_path">
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">商品説明</label>
                                <textarea
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    id="description" name="description">{{ old('description', $item->description) }}</textarea>
                            </div>

                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700">価格</label>
                                <input type="number"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    id="price" name="price" value="{{ old('price', $item->price) }}">
                            </div>

                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700">カテゴリー</label>
                                <select
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    id="category" name="category_id" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected(old('category') == $category->name)>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="is_show" class="block text-sm font-medium text-gray-700">商品の表示選択</label>
                                <select name="is_show" id="is_show"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="1" {{ $item->is_show == 1 ? 'selected' : '' }}>表示</option>
                                    <option value="0" {{ $item->is_show == 0 ? 'selected' : '' }}>非表示</option>
                                </select>
                            </div>

                            <div class="flex justify-end">
                                <a href="{{ route('seller.show', $item->id) }}"
                                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-3">戻る</a>
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">更新</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
