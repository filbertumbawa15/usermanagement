<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ConfigModulAkses extends Model
{
    use HasFactory;

    protected $guarded = [
        'uuid',
        'created_at',
        'updated_at'
    ];

    private $exceptAuthModule = [
        'settings',
    ];

    public function processStore(array $data): ConfigModulAkses
    {
        $configmodulakses = new ConfigModulAkses();
        $configmodulakses->id_level = $data['id_level'];
        $configmodulakses->id_config_modul = $data['id_config_modul'];
        $configmodulakses->create_user = auth('api')->user()->user;
        $configmodulakses->modified_user = auth('api')->user()->user;

        if (!$configmodulakses->save()) {
            throw new \Exception("Error storing config modul akses");
        }

        return $configmodulakses;
    }

    public function processUpdate(ConfigModulAkses $configModulAkses, array $data): ConfigModulAkses
    {
        $configModulAkses->id_level = $data['id_level'];
        $configModulAkses->id_config_modul = $data['id_config_modul'];
        $configModulAkses->modified_user = auth('api')->user()->user;

        if (!$configModulAkses->save()) {
            throw new \Exception("Error storing config modul akses");
        }

        return $configModulAkses;
    }

    public function processDestroy($id): ConfigModulAkses
    {
        $configModulAkses = new ConfigModulAkses();
        $del = $configModulAkses->where('id', $id)->delete();
        return $del;
    }

    public function checkAccessModule()
    {
        $data = [];

        $module = DB::table('config_user')
            ->leftJoin('config_modul_akses', 'config_user.id_level', 'config_modul_akses.id_level')
            ->leftJoin('config_modul', 'config_modul.uuid', 'config_modul_akses.id_config_modul')
            ->where('config_user.uuid', auth('api')->user()->uuid)
            ->orderBy('config_modul.urutan', 'asc')
            ->get([
                'config_modul.uuid',
                'config_modul.nama',
                'config_modul.folder',
                'config_modul.icon',
                'config_modul.logo',
                'config_modul.urutan',
            ]);

        foreach ($module as $index => $row) {
            $data[] = [
                'modul_id' => $row->uuid,
                'modul_name' => $row->nama,
                'module_icon' => $row->icon,
                'folder' => $row->folder,
                'logo' => $row->logo,
                'urutan' => $row->urutan,
            ];
        }

        return $data;
    }
}
