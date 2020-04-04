<?php

namespace Neliserp\Inventory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = request()->route('item');

        return [
            'code' => [
                'required',
                Rule::unique('items')->ignore($id ? $id : null),
            ],
            'name' => 'required',
        ];
    }
}
