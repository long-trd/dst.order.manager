<?php

namespace Cms\Modules\Core\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WheelEventRequest extends FormRequest
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
        $wheelEventId = $this->route('id');

        $validate['name'] = ['required', 'unique:wheel_events,name' . ($wheelEventId ? ',' . $wheelEventId : ''), 'max:191'];
        $validate['active_date'] = [
            'nullable',
            'date_format:Y-m-d H:i:s',
            'unique:wheel_events,active_date' . ($wheelEventId ? ',' . $wheelEventId : '')
        ];

        return $validate;
    }

    public function getValidatorInstance()
    {
        $this->formatActiveDate();

        return parent::getValidatorInstance();
    }

    protected function formatActiveDate()
    {
        if ($this->request->has('active_date') && strtotime($this->input('active_date'))) {
            $this->merge([
                'active_date' => date("Y-m-d 00:00:00", strtotime($this->input('active_date')))
            ]);
        }
    }

    public function messages()
    {
        return [
            'active_date.date_format' => 'The active date does not match the format d-m-Y'
        ];
    }
}
