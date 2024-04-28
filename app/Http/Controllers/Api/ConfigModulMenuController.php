<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ConfigModulMenu;
use App\Http\Requests\StoreConfigModulMenuRequest;
use App\Http\Requests\UpdateConfigModulMenuRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ConfigModulMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $limit = request('limit') ?? 10;
        $page = request('page') ?? 1;


        $query = DB::table((new ConfigModulMenu)->getTable())->select('config_modul_menu.*', 'config_modul.nama as nama_modul', 'menuparent.nama_menu as nama_menu_parent')->leftJoin('config_modul', 'config_modul_menu.id_config_modul', 'config_modul.uuid')->leftJoin('config_modul_menu as menuparent', 'config_modul_menu.id_parent', 'menuparent.uuid');
        $totalRecords = $query->count();

        if (request('filters')) {
            foreach (request('filters') as $index => $filter) {
                if($index == "nama_menu"){
                    $query = $query->orWhere('config_modul_menu.nama_menu', 'LIKE', "%$filter%");
                } else if ($index == "nama_menu_parent") {
                    $query = $query->orWhere('menuparent.nama_menu', 'LIKE', "%$filter%");
                } else if ($index == "nama_modul") {
                    $query = $query->orWhere('config_modul.nama', 'LIKE', "%$filter%");
                } else{
                    $query = $query->orWhere("config_modul_menu.$index", 'LIKE', "%$filter%");
                }
            }

            $totalRecords = $query->count();
        }

        if (isset(request('sorts')['column']) && isset(request('sorts')['direction'])) {
            $query = $query->orderBy(request('sorts')['column'], request('sorts')['direction']);
        }

        $totalPages = ceil($totalRecords / $limit);

        $categories = $query->skip(($page - 1) * $limit)->take($limit)->get();

        return response([
            'totalRecords' => $totalRecords,
            'totalPages' => $totalPages,
            'data' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreConfigModulMenuRequest $request)
    {
        $data = [
            'id_config_modul' => $request->id_config_modul,
            'nama_menu' => $request->nama_menu,
            'icon' => $request->icon,
            'link' => $request->link,
            'id_parent' => $request->id_parent,
            'nomor_urutan' => $request->nomor_urutan,
        ];

        DB::beginTransaction();
        try {
            $configModulMenu = (new ConfigModulMenu())->processStore($data);
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil disimpan.',
                'data' => $configModulMenu,
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $configModulMenu = DB::table((new ConfigModulMenu)->getTable())->select('config_modul_menu.*', 'config_modul.nama as nama_modul', 'menuparent.nama_menu as nama_menu_parent')->leftJoin('config_modul', 'config_modul_menu.id_config_modul', 'config_modul.uuid')->leftJoin('config_modul_menu as menuparent', 'config_modul_menu.id_parent', 'menuparent.uuid')->where('config_modul_menu.uuid',$id)->first();
        if ($configModulMenu) {
            return response([
                'data' => $configModulMenu,
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ConfigModulMenu $configModulMenu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConfigModulMenuRequest $request, ConfigModulMenu $configModulMenu)
    {
        $data = [
            'id_config_modul' => $request->id_config_modul,
            'nama_menu' => $request->nama_menu,
            'icon' => $request->icon,
            'link' => $request->link,
            'id_parent' => $request->id_parent,
            'nomor_urutan' => $request->nomor_urutan,
        ];

        DB::beginTransaction();
        try {
            $configModulMenu = (new ConfigModulMenu())->processUpdate($configModulMenu, $data);
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil disimpan.',
                'data' => $configModulMenu,
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $configModulMenu = (new ConfigModulMenu())->processDestroy($id);

            DB::commit();

            return response()->json([
                'message' => "Berhasil dihapus",
                'data' => $configModulMenu,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function getMenu(Request $request)
    {
        $getMenu = (new ConfigModulMenu())->getMenu($request->config_modul, 0);
        return $getMenu;
    }
}
