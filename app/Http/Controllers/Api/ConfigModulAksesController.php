<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ConfigModulAkses;
use App\Http\Requests\StoreConfigModulAksesRequest;
use App\Http\Requests\UpdateConfigModulAksesRequest;
use Illuminate\Support\Facades\DB;

class ConfigModulAksesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $limit = request('limit') ?? 10;
        $page = request('page') ?? 1;


        $query = DB::table((new ConfigModulAkses)->getTable());
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
    public function store(StoreConfigModulAksesRequest $request)
    {
        $data = [
            'id_level' => $request->id_level,
            'id_config_modul' => $request->id_config_modul,
        ];

        DB::beginTransaction();
        try {
            $configModulAkses = (new ConfigModulAkses())->processStore($data);
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil disimpan.',
                'data' => $configModulAkses,
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
        $configModulAkses = ConfigModulAkses::where('uuid', $id);
        if ($configModulAkses) {
            return response([
                'data' => $configModulAkses
            ]);
        }

        return response([
            'message' => 'No data found',
        ], 404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ConfigModulAkses $configModulAkses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConfigModulAksesRequest $request, ConfigModulAkses $configModulAkses)
    {
        $data = [
            'id_level' => $request->id_level,
            'id_config_modul' => $request->id_config_modul,
        ];

        DB::beginTransaction();
        try {
            $configModulAkses = (new ConfigModulAkses())->processUpdate($configModulAkses, $data);
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil disimpan.',
                'data' => $configModulAkses,
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
            $configModulAkses = (new ConfigModulAkses())->processDestroy($id);

            DB::commit();

            return response()->json([
                'message' => 'Berhasil dihapus',
                'data' => $configModulAkses
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function checkAccessModule()
    {
        $checkAccessModule = (new ConfigModulAkses())->checkAccessModule();

        return $checkAccessModule;
    }
}
