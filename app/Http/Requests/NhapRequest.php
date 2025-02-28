<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NhapRequest extends FormRequest
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
            'age' =>'nullable|numeric',
            'date'=>'nullable|string',
            'phone'=>'required|numeric',
            'web'=>'nullable|string',
            'address'=>'required|string'
        ];
    }

    public function messages(): array
{
    return [
        'name.required' => 'Tên không được để trống!',
        'name.string' => 'Vui lòng nhập đúng định dạng!',
        
        'age.numeric' => 'Vui lòng nhập đúng định dạng. Tuổi phải là số!',
        
        'date.string' => 'Vui lòng nhập đúng định dạng ngày!',
        
        'phone.required' => 'Số điện thoại không được để trống!',
        'phone.numeric' => 'Vui lòng nhập đúng định dạng số điện thoại!',
        
        'web.string' => 'Vui lòng kiểm tra lại định dạng website!',
        
        'address.required' => 'Địa chỉ không được để trống!',
        'address.string' => 'Vui lòng nhập chính xác địa chỉ!'
    ];
}
}
