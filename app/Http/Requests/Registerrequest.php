<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Registerrequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'user_name' => 'required',
          'email' => 'required|max:255',
          'password' => 'required|regex:/\A[a-z\d]{8,100}+\z/i',
          'password_confirmation' => 'required|same:password',
        ];
    }
}
