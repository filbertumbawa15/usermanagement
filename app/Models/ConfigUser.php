<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ConfigUser extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [
        'uuid',
        'created_at',
        'updated_at'
    ];

    protected $primaryKey = 'uuid';

    protected $table = "config_user";

    public function processStore(array $data)
    {
    	try {
            $configUser = new ConfigUser();

            $configUser->nama =  $data['nama'];
            $configUser->email =  $data['email'];
            $configUser->password =  $data['password'];
            $configUser->salt =  $data['password'];
            $configUser->id_level =  $data['id_level'];
            $configUser->hp =  $data['hp'];
            $configUser->photo =  $data['photo'];
            $configUser->token =  "";
            $configUser->status =  $data['status'];
            $configUser->create_user = auth('api')->user()->nama;
        	$configUser->modified_user = auth('api')->user()->nama;

            if (!$configUser->save()) {
                throw new \Exception('Error storing user');
            }

            return $configUser;
        } catch (\Throwable $th) {
            $this->deleteFiles($configUser);
            throw $th;
        }
    }

    public function processUpdate(ConfigUser $user, array $data)
    {
        $configUser = ConfigUser::find($data['uuid']);
        try {
            $configUser->nama =  $data['nama'];
            $configUser->email =  $data['email'];
            $configUser->password =  $configUser->password;
            $configUser->salt =  $configUser->salt;
            $configUser->id_level =  $data['id_level'];
            $configUser->hp =  $data['hp'];

            $this->deleteFiles($configUser);

            $configUser->photo =  $data['photo'];
            $configUser->token =  "";
            $configUser->status =  $data['status'];
            $configUser->modified_user = auth('api')->user()->nama;

            if (!$configUser->save()) {
                throw new \Exception('Error storing user');
            }

            return $configUser;
        } catch (\Throwable $th) {
            $this->deleteFiles($configUser);
            throw $th;
        }
    }

    public function processDestroy($id): ConfigUser
    {
        $configUser = new ConfigUser();
        $configUser = $configUser->where('uuid', $id)->first();
        $this->deleteFiles($configUser);
        $configUser->delete();

        return $configUser;
    }

    private function deleteFiles(ConfigUser $configUser)
    {
        $sizeTypes = ['', 'medium_', 'small_'];

        $relatedPhotoLampiran = [];

        $photoLampiran = json_decode($configUser->photo, true);

        if ($photoLampiran != '') {
            foreach ($photoLampiran as $path) {
            	$relatedPhotoLampiran[] = "photo/$path";
            }
            Storage::delete($relatedPhotoLampiran);
        }
    }
}
