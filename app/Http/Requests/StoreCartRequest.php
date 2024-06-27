<?php

namespace App\Http\Requests;

use App\Models\Item;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        $itemId = $this->route('item_id');
        $cartItem = Auth::user()->cartItems()->where('item_id', $itemId)->first();
        $cartItemAmount = $cartItem?->pivot->amount ?? 0;
        // そのユーザーがカートに追加できる実質の在庫数
        $realStock = Item::find($itemId)->stock - $cartItemAmount;

        return [
            'amount' => ['required', 'numeric','min:1', 'max:'.$realStock],
        ];
    }

    public function messages()
    {
        $itemId = $this->route('item_id');
        $cartItem = Auth::user()->cartItems()->where('item_id', $itemId)->first();
        $cartItemAmount = $cartItem?->pivot->amount ?? 0;
        return [
            'amount.required' => '数量を入力してください',
            'amount.numeric' => '数値で入力してください',
            'min' => '数量は1つ以上にしてください',
            'max' => '在庫数を超える注文はできません(カートに追加済みの数: '.$cartItemAmount.')',
        ];
    }
}
