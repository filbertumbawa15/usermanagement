<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ConfigModulMenu extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [
        'uuid',
        'created_at',
        'updated_at'
    ];

    protected $primaryKey = 'uuid';

    protected $table = "config_modul_menu";

    public function processStore(array $data): ConfigModulMenu
    {
        $configmodulmenu = new ConfigModulMenu();
        $configmodulmenu->id_config_modul = $data['id_config_modul'];
        $configmodulmenu->nama_menu = $data['nama_menu'];
        $configmodulmenu->icon = $data['icon'];
        $configmodulmenu->link = $data['link'];
        $configmodulmenu->id_parent = $data['id_parent'];
        $configmodulmenu->nomor_urutan = $data['nomor_urutan'];
        $configmodulmenu->create_user = auth('api')->user()->nama;
        $configmodulmenu->modified_user = auth('api')->user()->nama;

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
        $configModulMenu->modified_user = auth('api')->user()->nama;

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

    public function getMenu($valuesData, $induk = 0)
    {
        $data = [];
        $menu = ConfigModulMenu::select('config_modul_menu.*', 'config_modul.folder')->leftJoin('config_modul', 'config_modul_menu.id_config_modul', '=', 'config_modul.uuid')->where('config_modul.folder', $valuesData)->where('config_modul_menu.id_parent', "$induk")->orderby('config_modul_menu.nomor_urutan', 'ASC')->get();


        // $menu = Menu::leftJoin('acos', 'menu.aco_id', '=', 'acos.id')
        //     ->where('menu.menuparent', $induk)
        //     ->orderby(DB::raw('right(menukode,1)'), 'ASC')
        //     ->get(['menu.id', 'menu.aco_id', 'menu.menuseq', 'menu.menuname', 'menu.menuicon', 'acos.class', 'acos.method', 'menu.link', 'menu.menukode', 'menu.menuparent']);

        foreach ($menu as $index => $row) {
            $hasPermission = $this->_validatePermission($row->nama_menu);

            $value = $hasPermission['data'] == "" ? "" : $hasPermission['data'];

            if ($hasPermission['status'] || $row->id_parent == 0) {
                $data[] = [
                    'menu_id' => $row->uuid,
                    'menu_name' => $row->nama_menu,
                    'menu_icon' => $row->icon,
                    'link' => $row->folder . "/" . $row->link,
                    'urutan' => $row->nomor_urutan,
                    'child' => $this->getMenu($row->folder, $row->uuid),
                    'menu_parent' => $row->id_parent,
                    'baca' => $value->baca ?? null,
                    'tulis' => $value->tulis ?? null,
                    'ubah' => $value->ubah ?? null,
                    'hapus' => $value->hapus ?? null,
                ];
            }
        }

        return $data;
    }


    // public function hasPermission($nama_menu)
    // {
    //     // $class = strtolower($class);
    //     // $method = strtolower($method);

    //     return $this->_validatePermission($nama_menu);
    // }

    private function _validatePermission($nama_menu)
    {
        // if (!auth()->check()) {
        //     return redirect()->route('login');
        // }

        $data_union = DB::table('config_modul_level_akses')
            // ->select(['acos.id', 'acos.class', 'acos.method'])
            ->leftJoin('config_level', 'config_modul_level_akses.id_level', '=', 'config_level.uuid')
            ->leftJoin('config_modul_menu', 'config_modul_level_akses.id_menu', '=', 'config_modul_menu.uuid')
            // ->where('acos.class', 'like', "%$class%")
            // ->where('acos.class', '=', $class)
            ->where('config_modul_level_akses.id_level', auth()->user()->id_level)->get();

        // dd(array_column(json_decode($data_union), 'nama_menu'));
        if (in_array($nama_menu, array_column(json_decode($data_union), 'nama_menu')) == false) {
            return [
                'data' => "",
                'status' => false,
            ];
        }

        // $data = DB::table('acos')
        //     ->select(['acos.id', 'acos.class', 'acos.method'])
        //     ->join('useracl', 'acos.id', '=', 'useracl.aco_id')
        //     ->where('acos.class', '=', $class)
        //     // ->where('acos.class', 'like', "%$class%")
        //     ->where('useracl.user_id', auth()->user()->id)
        //     ->unionAll($data_union)
        //     ->get();

        // dd($data->tosql());
        // if ($this->in_array_custom($method, $data->toArray()) == false && in_array($method, $this->exceptAuth['method']) == false) {
        //     return false;
        // }
        $dataFilter = array_filter($data_union->toArray(), function ($obj) use ($nama_menu) {
            return $obj->nama_menu = $nama_menu;
        });
        return [
            'data' => $dataFilter[0],
            'status' => true,
        ];
    }
}
