<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConfigModulMenuRequest extends FormRequest
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
            'id_config_modul' => ['required', 'string'],
            'nama_menu' => ['required', 'string', 'unique:config_modul_menu'],
            'id_config_modul' => ['required', 'string'],
            'link' => ['required', 'string', 'unique:config_modul_menu'],
            'nomor_urutan' => ['required'],
        ];
    }
}
