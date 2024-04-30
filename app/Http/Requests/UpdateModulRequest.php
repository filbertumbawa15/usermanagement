<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateModulRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', Rule::unique('config_modul')->whereNotIn('uuid', [$this->uuid])],
            'folder' => ['required', 'string', Rule::unique('config_modul')->whereNotIn('uuid', [$this->uuid])],
            'icon' => ['required', 'string'],
            'urutan' => ['required'],
            'levelIds' => 'array',
            'levelIds.*' => 'required|exists:config_level,uuid',
        ];
    }
}
