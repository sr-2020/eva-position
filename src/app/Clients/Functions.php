<?php

namespace App\Functions;

use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class Functions {

    private $client;

    private $enable;

    public function __construct(array $config) {
        $this->enable = $config['enable'];

        $this->client = new Client([
            'base_uri' => $config['host'],
            'timeout'  => $config['timeout'],
        ]);
    }

    public function characterLocationChange(int $id, int $locationId, int $prevLocationId) {
        if (!$this->enable) {
            return true;
        }

        try {
            $response = $this->client->request('POST', '/characterLocationChange', [
                'json' => [
                    'id' => $id,
                    'locationId' => $locationId,
                    'prevLocationId' => $prevLocationId,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error("POST /characterLocationChange : " . $e->getMessage());
            return false;
        }

        if ($response->getStatusCode() !== Response::HTTP_CREATED) {
            Log::error("POST /characterLocationChange : " .
                $response->getStatusCode() . ": " . $response->getBody()->getContents());
            return false;
        }

        return true;
    }
}
