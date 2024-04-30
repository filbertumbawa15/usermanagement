<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [
        'uuid',
        'created_at',
        'updated_at'
    ];

    protected $primaryKey = 'uuid';

    protected $table = "config_level";

    public function processStore(array $data): Level
    {
        $level = new Level();
        $level->nama_level = $data['level'];
        $level->create_user = auth('api')->user()->nama;
        $level->modified_user = auth('api')->user()->nama;

        if (!$level->save()) {
            throw new \Exception("Error storing level");
        }

        return $level;
    }

    public function processUpdate(Level $level, array $data): Level
    {
        $level->nama_level = $data['level'];
        $level->modified_user = auth('api')->user()->nama;


        if (!$level->save()) {
            throw new \Exception("Error updating level");
        }

        return $level;
    }

    public function processDestroy($id): Level
    {
        $level = new Level();
        $del = $level->where('uuid', $id)->delete();
        return $level;
    }
}
