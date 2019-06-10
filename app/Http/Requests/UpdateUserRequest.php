<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        if ($this->hasFile('avatar')) {
           $rules = [
                'name' => 'required',
                'avatar' => 'image',
                'email' => ['required', Rule::unique('users')->ignore($this->route('user')->id)]
            ];
        }else{
            $rules = [
                'name' => 'required',
                'email' => ['required', Rule::unique('users')->ignore($this->route('user')->id)]
            ];
        }


        if ($this->filled('password')) {
            $rules['password'] = ['min:6'];
        }

        return $rules;
    }
}
