<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

/**
 * Unit tests for CashInOperationTest
 *
 * @author Petyo Ruzhin
 */
class CashInOperationTest extends TestCase
{
    private $naturalUser;

    protected function setUp()
    {
        parent::setUp();

        $this->naturalUser = new \App\NaturalPerson(
            1,
            0.03,
            5,
            'max',
            null,
            null
        );
    }

    /**
     * @test
     */
    public function that_default_commission_fee_is_correct()
    {
        $cashInOperation = new \App\CashInOperation(
            '2016-01-06',
            1000,
            'EUR',
            $this->naturalUser
        );
        // 1000 * 0.03% = 0.3
        $this->assertEquals(0.3, $cashInOperation->calculate());
    }

    /**
     * @test
     */
    public function commission_fee_is_no_more_than_amount_limit()
    {
        $cashInOperation = new \App\CashInOperation(
            '2016-01-06',
            20000,
            'EUR',
            $this->naturalUser
        );
        
        // 20000 * 0.03% = 6
        $res = $cashInOperation->calculate();

        // 6 > 5
        $this->assertEquals(5, $res);
        $this->assertNotEquals(6, $res);
    }
}
