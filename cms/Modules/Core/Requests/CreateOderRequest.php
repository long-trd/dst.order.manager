<?php

namespace Cms\Modules\Core\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOderRequest extends FormRequest
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
        $rules = [];

        if ($this->status == 'tracking' || $this->status == 'shipped') {
            $rules['tracking'] = 'required';
        }

        return $rules;
    }
}
