<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'inputName' => 'required|string|max:255',
            'inputImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'inputDescription' => 'required|string',
            'inputPrice' => 'required|numeric|min:0',
            'inputPromotionPrice' => 'nullable|numeric|min:0|lt:inputPrice',
            'inputUnit' => 'required|string|max:50',
            'inputNew' => 'required|boolean',
            'inputType' => 'required|integer|exists:product_types,id',
        ];
    }

    public function messages()
    {
        return [
            'inputName.required' => 'Tên sản phẩm không được để trống.',
            'inputImage.image' => 'File tải lên phải là hình ảnh.',
            'inputPrice.required' => 'Giá sản phẩm không được để trống.',
            'inputPromotionPrice.lt' => 'Giá khuyến mãi phải nhỏ hơn giá gốc.',
        ];
    }
}

