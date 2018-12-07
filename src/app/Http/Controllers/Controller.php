<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * @OA\Info(title="EVA API", version="0.0.1", contact={
 *     "email": "gurkalov.dev@gmail.com"
 *   })
 */

/**
 * @OA\Schema(
 *     schema="ErrorModel",
 *     required={"code", "message"},
 *     @OA\Property(
 *         property="code",
 *         type="integer",
 *         format="int32"
 *     ),
 *     @OA\Property(
 *         property="message",
 *         type="string"
 *     )
 * )
 */

class Controller extends BaseController
{
    //
}
