<?php

namespace App;

use Illuminate\Support\Facades\Validator;

class Model extends \Illuminate\Database\Eloquent\Model
{
    /*
     *
     */
    protected static $rules = [
        'common' => [],
        'create' => [],
        'update' => [],
    ];

    protected $validator;

    /**
     * @param $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validate($data)
    {
        $rules = static::$rules['common'];
        if (!$this->exists) {
            $rules = array_replace($rules, static::$rules['create']);
        } else {
            $rules = array_replace($rules, static::$rules['update']);
        }

        $this->validator = Validator::make($data, $rules);
        return $this->validator;
    }
}
