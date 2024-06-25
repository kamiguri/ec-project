<div class="container">
    <h1>商品編集</h1>
    <form action="/seller/item/{{$item->id}}/edit" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">商品名</label>
            <input type="text" class="form-control" id="name" name="name" value="{{old("name",$item->name)}}">
        </div>
        <div class="form-group">
            <label for="photo_path">写真</label>
            <input type="file" class="form-control-file" id="photo_path" name="photo_path" >
        </div>
        <div class="form-group">
            <label for="description">商品説明</label>
            <input type="text" class="form-control" id="description" name="description" value="{{old("description",$item->description)}}">
        </div>
        <div class="form-group">
            <label for="price">価格</label>
            <input type="number" class="form-control" id="price" name="price" value="{{old("price",$item->price)}}">
        </div>
        <div class="form-group">
            <label for="stock">在庫数</label>
            <input type="number" class="form-control" id="stock" name="stock" value="{{old("stock",$item->stock)}}">
        </div>
        <div class="form-group">
            <label for="category">カテゴリー</label>

        </div>
        <a href="{{ route('seller.show',$item->id) }}">商品詳細へ</a>
    </form>
</div>
