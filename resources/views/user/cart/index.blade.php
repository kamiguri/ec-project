<h1>cart.index</h1>

@foreach (Auth::user()->cartItems as $item)
<div>
    商品名: {{ $item->name }}
    <form action="{{ route('cart.update', $item->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label>数量:
            <input type="number" name="amount" value="{{ $item->pivot->amount }}">
        </label>
        <button type="submit">更新</button>
    </form>
    <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">削除</button>
    </form>
</div>
@endforeach
