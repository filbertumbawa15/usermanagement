<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Modul;
use App\Http\Requests\StoreModulRequest;
use App\Http\Requests\UpdateModulRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ModulController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $limit = request('limit') ?? 10;
        $page = request('page') ?? 1;


        $query = DB::table((new Modul)->getTable());
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
    public function store(StoreModulRequest $request)
    {
        $data = [
            'nama' => $request->nama,
            'folder' => $request->folder,
            'icon' => $request->icon,
            'urutan' => $request->urutan,
            // 'logo' => $request->logo,
            'levelIds' => $request->levelIds,
        ];

        DB::beginTransaction();
        try {
            $modul = (new Modul())->processStore($data);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil disimpan.',
                'data' => $modul,
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Modul::where('uuid', $id)->first();
        $levelData = Modul::rightJoin('config_modul_akses', 'config_modul.uuid', 'config_modul_akses.id_config_modul')->where('config_modul.uuid', $id)->get();

        return response([
            'data' => $data,
            'levelData' => $levelData,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Modul $level)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateModulRequest $request, Modul $modul)
    {
        $data = [
            'nama' => $request->nama,
            'folder' => $request->folder,
            'icon' => $request->icon,
            'urutan' => $request->urutan,
            // 'logo' => $request->logo,
            'levelIds' => $request->levelIds,
        ];

        DB::beginTransaction();
        try {
            $modul = (new Modul())->processUpdate($modul, $data);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil diubah.',
                'data' => $modul,
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
            $modul = (new Modul())->processDestroy($id);

            DB::commit();

            return response()->json([
                'message' => 'Berhasil dihapus',
                'data' => $modul
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function getModulByLevel(Request $request)
    {
        $data = DB::table('config_modul')->select('config_modul.uuid', 'config_modul.nama')->join('config_modul_akses', 'config_modul.uuid', 'config_modul_akses.id_config_modul')->where('config_modul_akses.id_level', $request->level)->get();
        return response([
            'data' => $data,
        ]);
    }
}
