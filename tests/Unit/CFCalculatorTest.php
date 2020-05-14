<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

/**
 * Unit tests for Operation entity
 *
 * @author Petyo Ruzhin
 */
class CFCalculatorTest extends TestCase
{
    private $cfc;

    protected function setUp()
    {
        parent::setUp();

        $this->cfc = new \App\CFCalculator();
    }

    /**
     * @test
     */
    public function that_cfcalculator_has_data()
    {
        $this->assertNotEmpty($this->cfc->getData());
    }

    /**
     * @test
     * @dataProvider provideInputCSVData
     */
    public function that_cfcalculator_has_valid_data($inputCSV)
    {
        $this->assertEquals($inputCSV, $this->cfc->getData());
    }

    /**
     * @test
     */
    public function that_cfcalculator_has_config()
    {
        $this->assertNotEmpty($this->cfc->getConfig());
    }

    /**
     * @test
     * @dataProvider provideInputINIData
     */
    public function that_cfcalculator_has_valid_config($inputINI)
    {
        $this->assertEquals($inputINI, $this->cfc->getConfig());
    }

    /**
     * @test
     */
    public function that_cfcalculator_has_user_storage()
    {
        $this->assertNotEmpty($this->cfc->getUserStorage());
    }

    /**
     * @test
     * @dataProvider provideCalculatedCommissionFeesData
     */
    public function that_calculated_commission_fees_are_correct($fees)
    {
        $cfs = $this->cfc->init();

        $this->assertEquals($cfs, $fees);
    }

    public function provideInputCSVData()
    {
        return  [
            [
                [
                    ['2014-12-31', '4', 'natural', 'cash_out', '1200.00', 'EUR'],
                    ['2015-01-01', '4', 'natural', 'cash_out', '1000.00', 'EUR'],
                    ['2016-01-05', '4', 'natural', 'cash_out', '1000.00' , 'EUR'],
                    ['2016-01-05', '1', 'natural', 'cash_in', '200.00', 'EUR'],
                    ['2016-01-06', '2', 'legal', 'cash_out', '300.00', 'EUR'],
                    ['2016-01-06', '1', 'natural', 'cash_out', '30000', 'JPY'],
                    ['2016-01-07', '1', 'natural', 'cash_out', '1000.00', 'EUR'],
                    ['2016-01-07', '1', 'natural', 'cash_out', '100.00', 'USD'],
                    ['2016-01-10', '1', 'natural', 'cash_out', '100.00', 'EUR'],
                    ['2016-01-10', '2', 'legal', 'cash_in', '1000000.00', 'EUR'],
                    ['2016-01-10', '3', 'natural', 'cash_out', '1000.00', 'EUR'],
                    ['2016-02-15', '1', 'natural', 'cash_out', '300.00', 'EUR'],
                    ['2016-02-19', '5', 'natural', 'cash_out', '3000000', 'JPY'],
                ]
            ]
        ];
    }

    public function provideCalculatedCommissionFeesData()
    {
        return [
            [
                [
                    '0.60',
                    '3.00',
                    '0.00',
                    '0.06',
                    '0.90',
                    '0',
                    '0.70',
                    '0.30',
                    '0.30',
                    '5.00',
                    '0.00',
                    '0.00',
                    '8612',
                ]
            ]
        ];
    }

    public function provideInputINIData()
    {
        return [
            [
                [
                    // CASH_IN
                    'CASH_IN' => [
                        'natural' => [
                            'default-cf' => '0.03',
                            'amount' => '5.00',
                            'amount-limit' => 'max'
                        ],
                        'legal' => [
                            'default-cf' => '0.03',
                            'amount' => '5.00',
                            'amount-limit' => 'max'
                        ]
                    ],
                    // CASH_OUT
                    'CASH_OUT' => [
                        'natural' => [
                            'default-cf' => '0.3',
                            'amount' => '1000',
                            'amount-limit' => 'max',
                            'operations' => '3',
                            'operations-limit' => 'max'
                        ],
                        'legal' => [
                            'default-cf' => '0.3',
                            'amount' => '0.50',
                            'amount-limit' => 'min'
                        ]
                    ],
                    // DefaultCurrency
                    'DefaultCurrency' => [
                        'EUR' => ''
                    ],
                    // ConversionRates
                    'ConversionRates' => [
                        'USD' => '1.1497',
                        'JPY' =>'129.53'
                    ],
                    // ValidCurrencies
                    'ValidCurrencies' => [
                        'EUR' => '',
                        'USD' => '',
                        'JPY' => ''
                    ],
                    // DefaultPrecision
                    'DefaultPrecision' => [
                        'EUR' => '2',
                        'USD' => '2',
                        'JPY' => '0'
                    ]
                ]
            ]
        ];
    }
}
