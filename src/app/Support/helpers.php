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
