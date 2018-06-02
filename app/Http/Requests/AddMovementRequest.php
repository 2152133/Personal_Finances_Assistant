<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddMovementRequest extends FormRequest
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
            'movement_account_id' => 'required|integer',
            'date' => 'required|date',
            'value' => 'required|integer',
            'description' => 'nullable|string|max:255',
        ];
    }
}
