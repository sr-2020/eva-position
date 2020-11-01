<?php

namespace App\Http\Controllers;

use App\Functions\Functions;
use App\Position;
use App\User;
use App\Beacon;
use App\Path;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Get(
 *     tags={"Position"},
 *     path="/api/v1/positions",
 *     description="Returns all positions",
 *     @OA\Parameter(
 *         name="limit",
 *         in="query",
 *         description="maximum number of results to return",
 *         required=false,
 *         example="10",
 *         @OA\Schema(
 *             type="integer",
 *             format="int32"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Position response",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Position")
 *         ),
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Position bad request",
 *         @OA\JsonContent(
 *             type="object"
 *         ),
 *     ),
 * )
 */

/**
 * @OA\Get(
 *     tags={"Position"},
 *     path="/api/v1/positions/{id}",
 *     description="Returns a position based on a single ID",
 *     operationId="getPosition",
 *     @OA\Parameter(
 *         description="ID of position to fetch",
 *         in="path",
 *         name="id",
 *         required=true,
 *         example=1,
 *         @OA\Schema(
 *             type="integer",
 *             format="int64",
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Position response",
 *         @OA\JsonContent(ref="#/components/schemas/Position"),
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Position bad request",
 *         @OA\JsonContent(
 *             type="object"
 *         ),
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="unexpected error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorModel"),
 *     )
 * )
 */

/**
 * @OA\Post(
 *     tags={"Position"},
 *     path="/api/v1/positions",
 *     operationId="createPosition",
 *     description="Creates a new position.",
 *     @OA\RequestBody(
 *         description="Position to add.",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(ref="#/components/schemas/NewPosition")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Position response",
 *         @OA\JsonContent(ref="#/components/schemas/Position")
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Position bad request",
 *         @OA\JsonContent(
 *             type="object"
 *         ),
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="unexpected error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorModel"),
 *     ),
 *      security={
 *         {"ApiKeyAuth": {"1"}}
 *     }
 * )
 */

/**
 * #OA\Put(
 *     tags={"Position"},
 *     path="/api/v1/positions/{id}",
 *     description="Update a position based on a single ID.",
 *     operationId="updatePosition",
 *     #OA\Parameter(
 *         description="ID of position to fetch",
 *         in="path",
 *         name="id",
 *         required=true,
 *         #OA\Schema(
 *             type="integer",
 *             format="int64",
 *         )
 *     ),
 *     #OA\RequestBody(
 *         description="Position to update.",
 *         required=true,
 *         #OA\MediaType(
 *             mediaType="application/json",
 *             #OA\Schema(ref="#/components/schemas/NewPosition")
 *         )
 *     ),
 *     #OA\Response(
 *         response=200,
 *         description="Position response",
 *         #OA\JsonContent(ref="#/components/schemas/Position"),
 *     ),
 *     #OA\Response(
 *         response="default",
 *         description="unexpected error",
 *         #OA\JsonContent(ref="#/components/schemas/ErrorModel"),
 *     )
 * )
 */

/**
 * #OA\Delete(
 *     tags={"Position"},
 *     path="/api/v1/positions/{id}",
 *     description="Deletes a single position based on the ID.",
 *     operationId="deletePosition",
 *     #OA\Parameter(
 *         description="ID of position to delete",
 *         in="path",
 *         name="id",
 *         required=true,
 *         #OA\Schema(
 *             format="int64",
 *             type="integer"
 *         )
 *     ),
 *     #OA\Response(
 *         response=204,
 *         description="Position deleted"
 *     ),
 *     #OA\Response(
 *         response="default",
 *         description="unexpected error",
 *         #OA\JsonContent(ref="#/components/schemas/ErrorModel"),
 *     )
 * )
 */
class PositionController extends Controller
{
    use Traits\CrudTrait;

    const MODEL = Position::class;

    /**
     * Simple strategy method
     *
     * @param  User  $user
     * @param  array $beacons
     * @return bool
     */
    protected function applySimpleStrategy(User $user, array $beacons)
    {
        $assignBeacon = self::assignBeacon($beacons);
        if (null === $assignBeacon) {
            return false;
        }

        self::createPath($user, $assignBeacon->location_id);
        $user->location_id = $assignBeacon->location_id;

        return true;
    }

    /**
     * Sum strategy method
     *
     * @param  User  $user
     * @param  integer $strategy
     * @return void
     */
    protected function applyFlowStrategy(User $user, $strategy)
    {
        $lastPositions = Position::where('user_id', $user->id)->orderBy('id', 'desc')->limit($strategy)->get();
        $countLastPositions = $lastPositions->count();

        if ($countLastPositions < $strategy - 1) {
            return ;
        }

        $beacons = [];
        foreach ($lastPositions as $position) {
            $beacon = self::assignBeacon($position->beacons);
            $beaconId = 0;
            if (null !== $beacon) {
                $beaconId = $beacon->id;
            }
            $beacons[] = $beaconId;
        }

        $countBeacons = array_count_values($beacons);
        arsort($countBeacons);
        $realBeaconId = key($countBeacons);

        if (0 === $realBeaconId && $countBeacons[0] > $strategy - 1) {
            //self::createPath($user, $realBeaconId);
           // $user->beacon_id = $realBeaconId;
            return ;
        }

        $realBeacon = Beacon::find($realBeaconId);
        if (null === $realBeacon) {
            return ;
        }

        $user->location_id = $realBeacon->location_id;

        //self::createPath($user, $realBeaconId);
        //$user->beacon_id = $realBeaconId;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $modelClass = self::MODEL;
        $validator = (new $modelClass())->validate($request->all());
        if ($validator->fails()) {
            return new JsonResponse($validator->errors(), JsonResponse::HTTP_BAD_REQUEST);
        }

        $model = $modelClass::create($request->all());

        $user = $request->user();
        $model->user_id = $user->id;
        $model->save();

        $strategy = config('position.strategy');
        $save = true;
        if ($strategy > 1) {
            $this->applyFlowStrategy($user, $strategy);
        } else {
            $save = $this->applySimpleStrategy($user, $model->beacons);
        }

        if ($save) {
            $user->touch();
            $user->save();
        }

        $response = $model->toArray();
        unset($response['beacons']);
        $response['location_id'] = $user->location_id;

        return new JsonResponse($response, JsonResponse::HTTP_CREATED);
    }

    /**
     * @param User $user
     * @param integer $locationId
     * @return void
     */
    protected function createPath(User $user, $locationId)
    {
        $iLocationId = (int)$locationId;

        if ($user->location_id !== $locationId) {
            Path::create([
                'user_id' => $user->id,
                'location_id' => $iLocationId,
            ]);

            $functions = app(Functions::class);
            $functions->characterLocationChange($user->id, $iLocationId, (int)$user->location_id);
            return;
        }

        $lastPath = Path::where('user_id', $user->id)->latest('id')->first();
        if (null !== $lastPath) {
            $lastPath->touch();
        }

        return;
    }

    /**
     * @param array $beacons
     * @return Beacon
     */
    protected function assignBeacon($beacons)
    {
        if (!is_array($beacons)) {
            return null;
        }
        $lowerBeacons = [];
        foreach ($beacons as $router) {
            $lowerBeacons[] = array_change_key_case($router, CASE_LOWER);
        }

        $sort = array_column($lowerBeacons, 'level', 'bssid');
        arsort($sort);
        if ([] !== $sort) {
            foreach ($sort as $key => $item) {
                $bssid = strtoupper($key);
                $beacon = Beacon::where('bssid', $bssid)->first();
                if (null !== $beacon) {
                    return $beacon;
                }
            }
        }
        return null;
    }
}
