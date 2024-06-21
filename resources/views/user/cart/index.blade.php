<h1>cart.index</h1>

@foreach (Auth::user()->cartItems as $item)
<div>
    商品名: {{ $item->name }}
    数量: {{ $item->pivot->amount }}
</div>
@endforeach
