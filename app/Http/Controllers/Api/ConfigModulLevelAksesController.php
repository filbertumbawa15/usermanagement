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
            $configModulLevelAkses = (new ConfigModulLevelAkses())->processStore($data);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil disimpan.',
                'data' => $configModulLevelAkses,
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
}
