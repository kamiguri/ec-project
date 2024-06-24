<h1>cart.index</h1>

@foreach (Auth::user()->cartItems as $item)
<div>
    商品名: {{ $item->name }}
    数量: {{ $item->pivot->amount }}
    <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">削除</button>
    </form>
</div>
@endforeach
