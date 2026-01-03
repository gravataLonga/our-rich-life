<?php

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{
    #[Test]
    public function clamp_between ()
    {
        $value = clamp(50, 0, 100);

        $this->assertSame($value, 50);
    }

    #[Test]
    public function clam_min ()
    {
        $value = clamp(-10, 0, 100);

        $this->assertSame($value, 0);
    }

    #[Test]
    public function clam_max ()
    {
        $value = clamp(200, 0, 100);

        $this->assertSame($value, 100);
    }

    #[Test]
    public function clamp_accept_callback()
    {
        $value = clamp(fn() => 50, 0, 100);

        $this->assertSame($value, 50);
    }

}
