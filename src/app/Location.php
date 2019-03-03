<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'label'
    ];

    protected $visible = [
        'id',
        'label'
    ];

    /**
     * Get users.
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }

    /**
     * Get the beacons for the location.
     */
    public function beacons()
    {
        return $this->belongsToMany('App\Beacon');
    }
}
