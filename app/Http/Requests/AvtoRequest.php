<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AvtoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        //
    }
    
    public function messages()
    {
        //
    }
}
