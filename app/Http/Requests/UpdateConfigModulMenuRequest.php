<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UpdateConfigModulMenuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $data = DB::table('config_modul_level_akses')->leftJoin('config_level', 'config_modul_level_akses.id_level', 'config_level.uuid')->leftJoin('config_modul_menu', 'config_modul_level_akses.id_menu', 'config_modul_menu.uuid')->where('config_modul_level_akses.id_level', auth()->user()->id_level)->where('config_modul_menu.link', $this->namamenu)->first();
        return $data->ubah == "Tidak" ? false : true;
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
            'nama_menu' => ['required', 'string', Rule::unique('config_modul_menu')->whereNotIn('uuid', [$this->uuid])],
            'id_config_modul' => ['required', 'string'],
            'link' => ['required', 'string', Rule::unique('config_modul_menu')->whereNotIn('uuid', [$this->uuid])],
            'nomor_urutan' => ['required'],
        ];
    }
}
