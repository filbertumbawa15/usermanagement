<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ConfigModulLevelAkses extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [
        'uuid',
        'created_at',
        'updated_at'
    ];

    public function processStore(array $data)
    {
        $temp = 'temp' . rand(1, getrandmax()) . str_replace('.', '', microtime(true));
        Schema::create($temp, function ($table) {
            $table->uuid('uuid')->primary();
            $table->string('id_level')->nullable();
            $table->string('id_menu', 1000)->nullable();
            $table->string('baca', 1000)->nullable();
            $table->string('tulis', 1000)->nullable();
            $table->string('ubah', 500)->nullable();
            $table->string('hapus', 500)->nullable();
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->string('create_user', 100)->nullable();
            $table->string('modified_user', 100)->nullable();
        });


        for ($i = 0; $i < count($data['dataMenu']); $i++) {
            DB::table($temp)->insert([
                'uuid' => Str::uuid(),
                'id_level' => $data['id_level'],
                'id_menu' => $data['dataMenu'][$i][0],
                'baca' => $data['dataMenu'][$i][2],
                'tulis' => $data['dataMenu'][$i][3],
                'ubah' => $data['dataMenu'][$i][4],
                'hapus' => $data['dataMenu'][$i][5],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'create_user' => auth('api')->user()->nama,
                'modified_user' => auth('api')->user()->nama,
            ]);
        }



        $update =  DB::table('config_modul_level_akses')
            ->join(DB::raw($temp . ' as b'), 'config_modul_level_akses.id_menu', '=', 'b.id_menu')
            // ->join('config_modul_menu', 'config_modul_menu.uuid', '=', 'b.id_menu')->toSql();
            ->update([
                'config_modul_level_akses.baca' => DB::raw('b.baca'),
                'config_modul_level_akses.tulis' => DB::raw('b.tulis'),
                'config_modul_level_akses.ubah' => DB::raw('b.ubah'),
                'config_modul_level_akses.hapus' => DB::raw('b.hapus'),
        ]);

        $models = DB::table($temp . ' as b')->select(
            'b.uuid',
            'b.id_level',
            'b.id_menu',
            'b.baca',
            'b.tulis',
            'b.ubah',
            'b.hapus',
            'b.create_user',
            'b.modified_user',
        )->leftJoin('config_modul_level_akses', 'b.id_menu', 'config_modul_level_akses.id_menu');

        if($models->first() !== null){     
            $insert = DB::table('config_modul_level_akses')->insertUsing(['uuid', 'id_level', 'id_menu', 'baca', 'tulis', 'ubah', 'hapus', 'create_user', 'modified_user'], $models);
        }

        Schema::drop($temp);

        $data = new ConfigModulLevelAkses();

        return $data;

        // dd($update);

        // $configmodullevelakses = new ConfigModulLevelAkses();
        // $configmodullevelakses->id_level = $data['id_level'];
        // $configmodullevelakses->id_menu = $data['id_menu'];
        // $configmodullevelakses->baca = $data['baca'];
        // $configmodullevelakses->tulis = $data['tulis'];
        // $configmodullevelakses->ubah = $data['ubah'];
        // $configmodullevelakses->hapus = $data['hapus'];
        // $configmodullevelakses->create_user = auth('api')->user()->user;
        // $configmodullevelakses->modified_user = auth('api')->user()->user;

        // if (!$configmodullevelakses->save()) {
        //     throw new \Exception("Error storing configmodullevelakses");
        // }

        return true;
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
