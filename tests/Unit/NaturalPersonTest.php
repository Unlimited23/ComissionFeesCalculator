<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

/**
 * Unit tests for NaturalPersonTest
 *
 * @author Petyo Ruzhin
 */
class NaturalPersonTest extends TestCase
{
    private $naturalUser;

    protected function setUp()
    {
        parent::setUp();

        $this->naturalUser = new \App\NaturalPerson(
            1,
            0.3,
            1000,
            'max',
            3,
            'max'
        );
    }

    /**
     * @test
     */
    public function that_add_used_amount_is_adding_up()
    {
        $dateWeek = $this->naturalUser->getWeekByDate('2016-01-06');
        // Adding 100 to the used amount
        $this->naturalUser->addUsedAmount($dateWeek, 100);

        $this->assertEquals(100, $this->naturalUser->getUsedAmount($dateWeek));

        // Adding 100 more
        $this->naturalUser->addUsedAmount($dateWeek, 100);
        
        $this->assertEquals(200, $this->naturalUser->getUsedAmount($dateWeek));
    }

    /**
     * @test
     */
    public function that_used_amount_is_weekly_based()
    {
        // 201601 - first week of 2016
        $dateWeek1 = $this->naturalUser->getWeekByDate('2016-01-06');
        // 201602 - second week of 2016
        $dateWeek2 = $this->naturalUser->getWeekByDate('2016-01-13');

        $this->naturalUser->addUsedAmount($dateWeek1, 100);
        $this->naturalUser->addUsedAmount($dateWeek2, 200);

        $this->assertNotEquals(
            $this->naturalUser->getUsedAmount($dateWeek1),
            $this->naturalUser->getUsedAmount($dateWeek2)
        );
    }
}
