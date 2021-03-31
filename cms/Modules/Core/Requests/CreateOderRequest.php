<?php

namespace Cms\Modules\Core\Requests;

use Cms\Modules\Core\Models\Account;
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
        $rules = [
            'account_ip' => [
                function ($attr, $values, $fail) {
                    if (!$values) return $fail('account ip not null');
                    if (!Account::where('ip_address', $values)->first()) return $fail('account is not registered');
                }
            ]
        ];

        if ($this->status == 'tracking' || $this->status == 'shipped') {
            $rules['tracking'] = 'required';
        }

        return $rules;
    }
}
