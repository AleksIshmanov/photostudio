<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeNewOrderUserRequest extends FormRequest
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
            'userName' => 'required|min:2',
            'textLink' => 'required',
            'mainPhotos' => 'required|array',
            'commonPhotos' => 'required|array',
            'designChoice' => 'required|array',
//            'userQuestionsAnswer' => 'min:10|max:100',
        ];
    }
}
