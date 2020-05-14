<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

/**
 * Unit tests for CashOutOperationForNaturalPersonTest
 *
 * @author Petyo Ruzhin
 */
class CashOutOperationForNaturalPersonTest extends TestCase
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
    public function commission_fee_when_no_amount_or_operation_limits_exceeded()
    {
        $cOutOperation = new \App\CashOutOperation(
            '2016-01-06',
            100,
            'EUR',
            $this->naturalUser
        );

        // 100 * 0 = 0 (no amount/operation limits exceeded)
        $this->assertEquals(0, $cOutOperation->calculate());
    }

    /**
     * @test
     */
    public function commission_fee_when_amount_limit_is_exceeded()
    {
        $cOutOperation = new \App\CashOutOperation(
            '2016-01-06',
            1500,
            'EUR',
            $this->naturalUser
        );
        // 1500 - 1000 = 500;
        // 500 * 0.3% = 1.5
        $cOutOperation->calculate(); // Amount limit exceeded at this point

        $cOutOperation2 = new \App\CashOutOperation(
            '2016-01-07',
            1500,
            'EUR',
            $this->naturalUser
        );

        // 1500 * 0.3% = 4.5
        $this->assertEquals(4.5, $cOutOperation2->calculate());
    }

    /**
     * @test
     */
    public function commission_fee_when_operation_limit_is_exceeded()
    {
        // 1
        $cOutOperation1 = new \App\CashOutOperation(
            '2016-01-06',
            150,
            'EUR',
            $this->naturalUser
        );
        $cOutOperation1->calculate();

        // 2
        $cOutOperation2 = new \App\CashOutOperation(
            '2016-01-07',
            150,
            'EUR',
            $this->naturalUser
        );
        $cOutOperation2->calculate();

        // 3
        $cOutOperation3 = new \App\CashOutOperation(
            '2016-01-08',
            150,
            'EUR',
            $this->naturalUser
        );
        $cOutOperation3->calculate();
        
        $cOutOperation4 = new \App\CashOutOperation(
            '2016-01-09',
            1500,
            'EUR',
            $this->naturalUser
        );

        // 1500 * 0.3% = 4.5
        $this->assertEquals(4.5, $cOutOperation4->calculate());
    }

    /**
     * @test
     */
    public function commission_fee_when_amount_limit_is_exceeded_before_operation_limit()
    {
        // 1
        $cOutOperation1 = new \App\CashOutOperation(
            '2016-01-06',
            150,
            'EUR',
            $this->naturalUser
        );
        $cOutOperation1->calculate(); // Total used amount is 150;

        // 2
        $cOutOperation2 = new \App\CashOutOperation(
            '2016-01-07',
            150,
            'EUR',
            $this->naturalUser
        );
        $cOutOperation2->calculate(); // Total used amount is 300;

        // 3
        $cOutOperation3 = new \App\CashOutOperation(
            '2016-01-08',
            1500,
            'EUR',
            $this->naturalUser
        ); // Total used amount is 1800;

        // 1800 - 1000 = 800;
        // 800 * 0.3% = 2.4
        $this->assertEquals(2.4, $cOutOperation3->calculate());
    }
    
    /**
     * @test
     */
    public function that_commission_fee_is_calculated_based_on_exceeded_amount()
    {
        $cOutOperation = new \App\CashOutOperation(
            '2016-01-06',
            1500,
            'EUR',
            $this->naturalUser
        );
        // 1500 - 1000 = 500;
        // 500 * 0.3% = 1.5
        $this->assertEquals(1.5, $cOutOperation->calculate());
    }
}
