<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SaveSettingsPost extends FormRequest
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
        return [
            'username' => 'nullable|min:3',
            'changePassword' => 'required|boolean',
            'oldPassword' => 'required_if:changePassword,true|string|min:4',
            'newPassword' => 'required_if:changePassword,true|string|min:4',
            'repassword' => 'required_if:changePassword,true|string|min:4|same:newPassword'
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator){
        $validator->after(function ($validator) {
            $user = Auth::user();
            if ($this->changePassword && !Hash::check($this->oldPassword, $user->password) ) {
                $validator->errors()->add('password', 'Incorrect password!');
            }
        });
    }
}
