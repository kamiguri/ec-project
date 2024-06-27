<?php

namespace App\Http\Requests;

use App\Models\Item;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $itemId = $this->route('item_id');

        return [
            'amount' => ['required', 'numeric','min:1', 'max:'.Item::find($itemId)->stock ],
        ];
    }

    public function messages()
    {
        return [
            'amount.required' => '数量を入力してください',
            'amount.numeric' => '数値で入力してください',
            'min' => '数量は1つ以上にしてください',
            'max' => '在庫数を超える注文はできません',
        ];
    }
}
