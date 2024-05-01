<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ConfigUser;
use App\Http\Requests\StoreConfigUserRequest;
use App\Http\Requests\UpdateConfigUserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ConfigUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $limit = request('limit') ?? 10;
        $page = request('page') ?? 1;

        $query = DB::table((new ConfigUser)->getTable())->select('config_user.*', 'config_level.nama_level')->leftJoin('config_level', 'config_user.id_level', 'config_level.uuid');

        $totalRecords = $query->count();

        // if (request('filters')) {
        //     foreach (request('filters') as $index => $filter) {
        //         if ($index == "nama_level") {
        //             $query = $query->orWhere('config_level.nama_level', 'LIKE', "%$filter%");
        //         } else {
        //             $query = $query->orWhere($index, 'LIKE', "%$filter%");
        //         }
        //     }

        //     $totalRecords = $query->count();
        // }

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
    public function store(StoreConfigUserRequest $request)
    {
        DB::beginTransaction();
        try {
            $storedFile = [];
            foreach ($request->photo as $files) {
                $filesPath = $this->storeFiles($files, 'photo');
                $storedFile[] = $filesPath;
            }

            $data = [
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'id_level' => $request->id_level,
                'hp' => $request->hp,
                'photo' => json_encode($storedFile) ?? "",
                'status' => $request->status,
            ];
            $configUser = (new ConfigUser())->processStore($data);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil disimpan.',
                'data' => $configUser,
            ], 201);
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();          
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $configUser = ConfigUser::where('uuid', $id)->first();
        if ($configUser) {
            return response([
                'data' => $configUser
            ]);
        }

        return response([
            'message' => 'No data found',
        ], 404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ConfigUser $configUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConfigUserRequest $request, ConfigUser $user)
    {
        DB::beginTransaction();
        try {
            $storedFile = [];
            foreach ($request->photo as $files) {
                $filesPath = $this->storeFiles($files, 'photo');
                $storedFile[] = $filesPath;
            }

            $data = [
                'uuid' => $request->uuid,
                'nama' => $request->nama,
                'email' => $request->email,
                'id_level' => $request->id_level,
                'hp' => $request->hp,
                'photo' => json_encode($storedFile) ?? "",
                'status' => $request->status,
            ];
            $configUser = (new ConfigUser())->processUpdate($user, $data);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil diubah.',
                'data' => $configUser,
            ]);
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();          
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $configUser = (new ConfigUser())->processDestroy($id);

            DB::commit();

            return response()->json([
                'message' => 'Berhasil dihapus',
                'data' => $configUser
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    private function storeFiles($files, string $destinationFolder): string
    {
        $originalFileName = $files->hashName();
        $storedFile = Storage::putFileAs("photo", $files, $originalFileName);

        return $originalFileName;
    }

    public function getImage(string $field, string $filename, string $type, string $aksi)
    {
        if (Storage::exists("photo/$filename")) {
            return response()->file(storage_path("app/photo/$filename"));
        } else {
            if (Storage::exists("photo/$filename")) {
                if ($aksi == "edit") {
                    return response()->file(storage_path("app/photo/$filename"));
                } else {
                    return response()->file(storage_path("app/no-image.jpg"));
                }
            } else {
                if ($aksi == 'show') {
                    return response()->file(storage_path("app/no-image.jpg"));
                } else {
                    return response('no-image');
                }
            }
        }
    }
}
