<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeNewOrderRequest extends FormRequest
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
            'taskName' => 'required|min:5',
            'individualPhotosCount' => 'required|numeric',
            'photosAll' => 'required|numeric',
            'commonPhotosToCustomer' => 'required|numeric',
            'photoAlbumLink' => 'required|url',
            'designsCount' => 'required|numeric',
            'dirName' => 'required',
        ];
    }
}
