<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FirmRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'nameEng' => 'required',
            'skk' => 'required',
            'nameNSO' => 'required',
            'famNSO' => 'required',
            'otchNSO' => 'required',
            'ipStart' => 'required',
            'ipEnd' => 'required',
            'addr' => 'required',
        ];
    }
    
    public function messages() {
    return [
            'name' => 'Это обязательное поле',
            'nameEng' => 'Это обязательное поле',
            'skk' => 'Это обязательное поле',
            'nameNSO' => 'Это обязательное поле',
            'famNSO' => 'Это обязательное поле',
            'otchNSO' => 'Это обязательное поле',
            'ipStart' => 'Это обязательное поле',
            'ipEnd' => 'Это обязательное поле',
            'addr' => 'Это обязательное поле',
        ];
    }
}
