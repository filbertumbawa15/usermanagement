<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ConfigModulLevelAkses;
use App\Http\Requests\StoreConfigModulLevelAksesRequest;
use App\Http\Requests\UpdateConfigModulLevelAksesRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ConfigModulLevelAksesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $limit = request('limit') ?? 10;
        $page = request('page') ?? 1;


        $query = DB::table((new ConfigModulLevelAkses)->getTable());
        $totalRecords = $query->count();

        if (request('filters')) {
            foreach (request('filters') as $index => $filter) {
                $query = $query->orWhere($index, 'LIKE', "%$filter%");
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
    public function store(StoreConfigModulLevelAksesRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = [
                'id_level' => $request->id_level,
                'dataMenu' => $request->dataMenu,
            ];
            $configModulLevelAkses = (new ConfigModulLevelAkses())->processStore($data);

            // DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil disimpan.',
                'data' => $configModulLevelAkses,
            ], 200);
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
        $configModulLevelAkses = ConfigModulLevelAkses::where('uuid', $id);
        if ($configModulLevelAkses) {
            return response([
                'data' => $configModulLevelAkses
            ]);
        }

        return response([
            'message' => 'No data found',
        ], 404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ConfigModulLevelAkses $configModulLevelAkses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConfigModulLevelAksesRequest $request, ConfigModulLevelAkses $configModulLevelAkses)
    {
        $data = [
            'id_level' => $request->id_level,
            'id_menu' => $request->id_menu,
            'baca' => $request->baca,
            'tulis' => $request->tulis,
            'ubah' => $request->ubah,
            'hapus' => $request->hapus,
        ];

        DB::beginTransaction();
        try {
            $configModulLevelAkses = (new ConfigModulLevelAkses())->processUpdate($configModulLevelAkses, $data);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil diubah.',
                'data' => $configModulLevelAkses,
            ]);
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
            $configModulLevelAkses = (new ConfigModulLevelAkses())->processDestroy($id);

            DB::commit();

            return response()->json([
                'message' => 'Berhasil dihapus',
                'data' => $configModulLevelAkses
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function hasPermission(Request $request)
    {
        $result = (new ConfigModulLevelAkses())->hasPermission($request->accessMenu);
        return $result;
    }

    public function getLevelAksesByModul(Request $request) {
        
        $idLevel = $request->id_level;
        $idConfig = $request->id_config;

        $dataWhere = DB::table('config_modul_menu')->select(
            'config_modul_menu.uuid',
            'config_modul_menu.nama_menu',
            DB::raw("IFNULL(config_modul_level_akses.baca, 'Tidak') as baca"),
            DB::raw("IFNULL(config_modul_level_akses.tulis, 'Tidak') as tulis"),
            DB::raw("IFNULL(config_modul_level_akses.ubah, 'Tidak') as ubah"),
            DB::raw("IFNULL(config_modul_level_akses.hapus, 'Tidak') as hapus"),
        )->leftJoin('config_modul_level_akses', 'config_modul_menu.uuid', 'config_modul_level_akses.id_menu')->where('config_modul_menu.id_config_modul', $idConfig)->where('config_modul_menu.id_parent', '!=', "0")->whereRaw(DB::raw('ISNULL(config_modul_level_akses.baca)'));

        $data = DB::table('config_modul_menu')->select(
            'config_modul_menu.uuid',
            'config_modul_menu.nama_menu', 
            'config_modul_level_akses.baca', 
            'config_modul_level_akses.tulis', 
            'config_modul_level_akses.ubah', 
            'config_modul_level_akses.hapus'
            )->leftJoin('config_modul_level_akses', 'config_modul_menu.uuid', 'config_modul_level_akses.id_menu')->where('config_modul_level_akses.id_level', $idLevel)->where('config_modul_menu.id_config_modul', $idConfig)->where('config_modul_menu.id_parent', '!=', "0")->union($dataWhere)->get();

        
        return $data;

    }
}
