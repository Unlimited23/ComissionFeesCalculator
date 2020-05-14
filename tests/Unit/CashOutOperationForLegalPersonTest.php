<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

/**
 * Unit tests for CashOutOperationForLegalPersonTest
 *
 * @author Petyo Ruzhin
 */
class CashOutOperationForLegalPersonTest extends TestCase
{
    private $legalUser;

    protected function setUp()
    {
        parent::setUp();

        $this->legalUser = new \App\LegalPerson(
            1,
            0.3,
            0.50,
            'min',
            null,
            null
        );
    }

    /**
     * @test
     */
    public function that_default_commission_fee_is_correct()
    {
        $cOutOperation = new \App\CashOutOperation(
            '2016-01-06',
            1000,
            'EUR',
            $this->legalUser
        );

        // 1000 * 0.3% = 3
        $this->assertEquals(3, $cOutOperation->calculate());
    }

    /**
     * @test
     */
    public function commission_fee_is_no_less_than_amount_limit()
    {
        $cOutOperation = new \App\CashOutOperation(
            '2016-01-06',
            100,
            'EUR',
            $this->legalUser
        );

        // 100 * 0.3% = 0.3
        // 0.3 < 0.5
        $res = $cOutOperation->calculate();

        $this->assertEquals(0.5, $res);
        $this->assertNotEquals(0.3, $res);
    }
}
