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
                    <div class="container">
                        <form action="/seller/item/{{$item->id}}/edit" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">商品名</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{old("name",$item->name)}}">
                            </div>

                            <div class="form-group">
                                <label for="photo_path">写真</label>
                                @if ($item->photo_path)
                                    <div>
                                        <img src="{{ asset($item->photo_path) }}" alt="Current Photo" style="max-height: 200px;">
                                    </div>
                                @endif
                                <input type="file" class="form-control-file" id="photo_path" name="photo_path">
                            </div>
                            <div class="form-group">
                                <label for="description">商品説明</label>
                                <textarea class="form-control" id="description" name="description">{{old("description",$item->description)}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="price">価格</label>
                                <input type="number" class="form-control" id="price" name="price" value="{{old("price",$item->price)}}">
                            </div>
                            <div class="form-group">
                                <label for="category">カテゴリー</label>
                                <select class="form-control" id="category" name="category_id" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected(old("category") == $category->name)>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="is_show">商品の表示選択</label>
                                <select name="is_show" id="is_show">
                                    <option value="1" {{ $item->is_show == 1 ? 'selected' : '' }}>表示</option>
                                    <option value="0" {{ $item->is_show == 0 ? 'selected' : '' }}>非表示</option>
                                </select>
                            </div>
                            <a href="{{ route('seller.show',$item->id) }}">戻る</a>
                            <button type="submit">更新</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
