<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modul extends Model
{
    use HasFactory, HasUuids;

    protected $table = "config_modul";

    protected $casts = [
        'id' => 'string',
    ];

    protected $primaryKey = 'uuid';


    public function processStore(array $data): Modul
    {
        $modul = new Modul();
        $modul->nama = $data['nama'];
        $modul->folder = $data['folder'];
        $modul->icon = $data['icon'];
        $modul->urutan = $data['urutan'];
        $modul->logo = 'a.jpg';
        $modul->create_user = auth('api')->user()->nama;
        $modul->modified_user = auth('api')->user()->nama;

        if (!$modul->save()) {
            throw new \Exception("Error storing level");
        }

        $configModulAkses = [];

        for ($i = 0; $i < count($data['levelIds']); $i++) {
            $bagianDetail = (new ConfigModulAkses())->processStore($modul, [
                'id_level' => $data['levelIds'][$i],
            ]);

            $bagianDetails[] = $bagianDetail->toArray();
        }

        return $modul;
    }

    public function processUpdate(Modul $modul, array $data): Modul
    {
        $modul->nama = $data['nama'];
        $modul->folder = $data['folder'];
        $modul->icon = $data['icon'];
        $modul->urutan = $data['urutan'];
        $modul->logo = 'a.jpg';
        $modul->modified_user = auth('api')->user()->nama;

        if (!$modul->save()) {
            throw new \Exception("Error storing level");
        }

        ConfigModulAkses::where('id_config_modul', $modul->uuid)->delete();

        $configModulAkses = [];

        for ($i = 0; $i < count($data['levelIds']); $i++) {
            $bagianDetail = (new ConfigModulAkses())->processStore($modul, [
                'id_level' => $data['levelIds'][$i],
            ]);

            $bagianDetails[] = $bagianDetail->toArray();
        }

        return $modul;
    }

    public function processDestroy($id): Modul
    {
        $modul = new Modul();
        ConfigModulAkses::where('id_config_modul', $id)->delete();
        $del = $modul->where('uuid', $id)->delete();
        return $modul;
    }
}
