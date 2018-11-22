<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
                return [
                    'name' => 'required|string|between:1,32|unique:users',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|string|between:6,32|confirmed',
                ];

            case 'PUT':
                return [
                    'name' => 'string|between:1,32|unique:users,name,'.\Auth::id(),
                    'password' => 'string|between:6,32|confirmed',
                    'introduction' => 'max:255',
                    'avatar' => 'mimes:jpg,jpeg,bmp,png,gif|dimensions:min_width=200,min_height=200',
                ];
        }
    }


    public function attributes()
    {
        return [
            'name' => '用户名',
            'email' => '邮箱',
            'password' => '密码',
            'introduction' => '个人介绍',
            'avatar' => '头像',
        ];
    }


    public function messages()
    {
        return [
            'avatar.dimensions' => '头像图片的像素至少200x200',
        ];
    }
}
