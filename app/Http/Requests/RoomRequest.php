<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
        return [
            'name'=>'required|string',
            'price' =>'required|numeric',
            'des' => 'required|string',
            'image' => 'required'
        ];
    }

    public function messages(): array
{
    return [
        'name.required' => 'Tên không được để trống!',
        'name.string' => 'Vui lòng nhập đúng định dạng!',
        
        'price.required' => 'Vui lòng nhập giá phòng!',
        'price.numeric' => 'Vui lòng nhập đúng định dạng. Tuổi phải là số!',
        
        'des.required' => 'Mô tả không được để trống!',
        'des.string' => 'Vui lòng nhập đúng định dạng!',
        
        'image.required' => 'Địa chỉ không được để trống!'
    ];
}
}
// Bài test nhóm (Code đầy đủ trên github Dominic(Đức Đạt))