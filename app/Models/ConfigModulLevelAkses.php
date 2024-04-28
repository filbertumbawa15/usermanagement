<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigModulLevelAkses extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [
        'uuid',
        'created_at',
        'updated_at'
    ];

    public function processStore(array $data): ConfigModulLevelAkses
    {
        $configmodullevelakses = new ConfigModulLevelAkses();
        $configmodullevelakses->id_level = $data['id_level'];
        $configmodullevelakses->id_menu = $data['id_menu'];
        $configmodullevelakses->baca = $data['baca'];
        $configmodullevelakses->tulis = $data['tulis'];
        $configmodullevelakses->ubah = $data['ubah'];
        $configmodullevelakses->hapus = $data['hapus'];
        $configmodullevelakses->create_user = auth('api')->user()->user;
        $configmodullevelakses->modified_user = auth('api')->user()->user;

        if (!$configmodullevelakses->save()) {
            throw new \Exception("Error storing configmodullevelakses");
        }

        return $configmodullevelakses;
    }

    public function processUpdate(ConfigModulLevelAkses $configModulLevelAkses, array $data): ConfigModulLevelAkses
    {
        $configModulLevelAkses->id_level = $data['id_level'];
        $configModulLevelAkses->id_menu = $data['id_menu'];
        $configModulLevelAkses->baca = $data['baca'];
        $configModulLevelAkses->tulis = $data['tulis'];
        $configModulLevelAkses->ubah = $data['ubah'];
        $configModulLevelAkses->hapus = $data['hapus'];
        $configModulLevelAkses->modified_user = auth('api')->user()->user;

        if (!$configModulLevelAkses->save()) {
            throw new \Exception("Error updating configmodullevelakses");
        }

        return $configModulLevelAkses;
    }

    public function processDestroy($id): Level
    {
        $configModulLevelAkses = new ConfigModulLevelAkses();
        $del = $configModulLevelAkses->where('id', $id)->delete();
        return $del;
    }

    public function hasPermission($param)
    {
        $data = ConfigModulLevelAkses::leftJoin('config_modul_menu', 'config_modul_level_akses.id_menu', '=', 'config_modul_menu.uuid')->where('config_modul_menu.link', $param)->where('config_modul_level_akses.id_level', auth()->user()->id_level)->first(['config_modul_level_akses.baca', 'config_modul_level_akses.tulis', 'config_modul_level_akses.ubah', 'config_modul_level_akses.hapus', 'config_modul_menu.link']);

        return $data;
    }
}
