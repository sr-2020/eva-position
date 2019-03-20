<?php

use Carbon\Carbon;

if (! function_exists('now')) {
    /**
     * Create a new Carbon instance for the current time.
     *
     * @return \Carbon\Carbon
     */
    function now()
    {
        return Carbon::now();
    }
}

if (! function_exists('app_swagger_lume_asset')) {
    /**
     * Returns asset from swagger-ui composer package.
     *
     * @param $asset string
     *
     * @return string
     * @throws \SwaggerLume\Exceptions\SwaggerLumeException
     */
    function app_swagger_lume_asset($asset)
    {
        $file = swagger_ui_dist_path($asset);

        if (! file_exists($file)) {
            throw new SwaggerLumeException(sprintf('Requested L5 Swagger asset file (%s) does not exists', $asset));
        }

        $directory = config('swagger-lume.routes.assets');
        return $directory . '/' . $asset . '?v=' . md5($file);
    }
}
