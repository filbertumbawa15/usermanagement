<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigModulMenu extends Model
{
    use HasFactory;

    protected $guarded = [
        'uuid',
        'created_at',
        'updated_at'
    ];

    public function processStore(array $data): ConfigModulMenu
    {
        $configmodulmenu = new ConfigModulMenu();
        $configmodulmenu->id_config_modul = $data['id_config_modul'];
        $configmodulmenu->nama_menu = $data['nama_menu'];
        $configmodulmenu->icon = $data['icon'];
        $configmodulmenu->link = $data['link'];
        $configmodulmenu->id_parent = $data['id_parent'];
        $configmodulmenu->nomor_urutan = $data['nomor_urutan'];

        if (!$configmodulmenu->save()) {
            throw new \Exception('Error storing config module menu');
        }

        return $configmodulmenu;
    }

    public function processUpdate(ConfigModulMenu $configModulMenu, array $data): ConfigModulMenu
    {
        $configModulMenu->id_config_modul = $data['id_config_modul'];
        $configModulMenu->nama_menu = $data['nama_menu'];
        $configModulMenu->icon = $data['icon'];
        $configModulMenu->link = $data['link'];
        $configModulMenu->id_parent = $data['id_parent'];
        $configModulMenu->nomor_urutan = $data['nomor_urutan'];

        if (!$configModulMenu->save()) {
            throw new \Exception('Error storing config module menu');
        }

        return $configModulMenu;
    }

    public function processDestroy($id): ConfigModulMenu
    {
        $configmodulmenu = new ConfigModulMenu();
        $del = $configmodulmenu->where('id', $id)->delete();
        return $del;
    }
}
