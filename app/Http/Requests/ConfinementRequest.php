<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfinementRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
                return [
                    'is_permanent' => 'required|boolean',
                    'expired_in_days' => 'required|nullable|in:null,1,7,30',
                ];

            default:
                return [];
        }
    }
}
