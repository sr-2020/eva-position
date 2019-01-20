<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Router;

/**
 *  @OA\Schema(
 *   schema="Audio",
 *   type="object",
 *   allOf={
 *       @OA\Schema(
 *           required={"id"},
 *           @OA\Property(property="id", format="int64", type="integer"),
 *           @OA\Property(property="user_id", format="int64", type="integer"),
 *           @OA\Property(property="filename", format="string", type="string"),
 *       )
 *   }
 * )
*/
class Audio extends Model
{
    protected $table = 'audios';

    protected $fillable = [
        'filename',
        'user_id',
    ];

    protected $visible = [
        'id',
        'filename',
        //'user_id',
    ];
}
