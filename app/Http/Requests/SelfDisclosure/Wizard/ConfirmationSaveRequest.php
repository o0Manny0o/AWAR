<?php

namespace App\Http\Requests\SelfDisclosure\Wizard;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmationSaveRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'not_banned' => ['required', 'accepted'],
            'accepted_inaccuracy' => ['required', 'accepted'],
            'has_proof_of_identity' => ['required', 'accepted'],
            'everyone_agrees' => ['required', 'accepted'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
