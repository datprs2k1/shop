<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ChangePassword extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'password' => 'required|min:6',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ];
    }

    public function attributes()
    {
        return [
            'password' => 'Mật khẩu cũ',
            'new_password' => 'Mật khẩu mới',
            'confirm_password' => 'Xác nhận mật khẩu',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được để trống.',
            'min' => ':attribute phải có ít nhất :min ký tự.',
            'same' => ':attribute không khớp.',
        ];
    }
}
