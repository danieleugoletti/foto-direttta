<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Helpers\HashidHelper;

class HashidHelperTest extends TestCase
{
    /**
     * @test
     */
    public function a_hash_must_have_a_minimum_length()
    {
        $hashidHelper = new HashidHelper();
        $this->assertGreaterThanOrEqual(5, strlen($hashidHelper->encodeId(1)));
    }

    /**
     * @test
     */
    public function a_hash_must_encode_decode_successful()
    {
        $hashidHelper = new HashidHelper();
        $encoded = $hashidHelper->encodeId(1);
        $decoded = $hashidHelper->decodeId($encoded);
        $this->assertEquals(1, $decoded);
    }
}

