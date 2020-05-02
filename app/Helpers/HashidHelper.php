<?php

namespace App\Helpers;

use Hashids\Hashids;

class HashidHelper
{
    private $hashids;

    /**
     * @param string $salt
     */
    public function __construct($salt=null)
    {
        $this->hashids = new Hashids($salt, 5);
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
