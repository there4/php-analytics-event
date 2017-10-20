<?php
namespace Tests\Unit;

use Tests\TestCase;
use There4\Analytics\AnalyticsEvent;

class SanityTest extends TestCase
{
    /**
     * @test
     */
    public function canInstantiate()
    {
        $this->assertInstanceOf(
            AnalyticsEvent::class,
            new AnalyticsEvent('UAxxxxxxx', 'example.com')
        );
    }
}

/* End of file SanityTest.php */
