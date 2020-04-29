<?php

namespace App\Helpers;

use Hashids\Hashids;

class HashidHelper
{
    private $hashids;

    public function __construct()
    {
        $this->hashids = new Hashids(config('app.key'), 5);
    }

    public function encodeId($id)
    {
        return $this->hashids->encode($id);
    }

    public function decodeId($id)
    {
        $decoded = $this->hashids->decode($id);
        return count($decoded) ? $decoded[0] : null;
    }
}
