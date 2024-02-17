<?php

namespace Cms\Modules\Core\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrizeRequest extends FormRequest
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
        $prizeId = $this->route('id');

        $validate['text'] = ['required', 'max:191'];
        $validate['img'] = ['mimes:jpeg,png,jpg,gif,svg', 'max:2048'];
        $validate['unit'] = ['required', 'max:191'];
        $validate['number'] = ['required', 'numeric', 'min:0', 'max:1000'];
        $validate['percentage'] = ['required', 'numeric', 'max:100', 'min:0'];
        $validate['wheel_event_id'] = ['required'];

        if (!$prizeId)
            $validate['img'] = 'required';

        return $validate;
    }
}
