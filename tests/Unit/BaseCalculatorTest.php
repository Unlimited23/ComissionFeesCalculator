<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use App\BaseCalculator;

/**
 * Unit tests for BaseCalculatorTest
 *
 * @author Petyo Ruzhin
 */
class BaseCalculatorTest extends TestCase
{
    /**
     * @test
     */
    public function that_we_can_add_positive_numbers()
    {
        $this->assertEquals(2, BaseCalculator::bAdd(1, 1));
    }

    /**
     * @test
     */
    public function that_we_can_add_negative_numbers()
    {
        $this->assertEquals(-2, BaseCalculator::bAdd(-1, -1));
    }

    /**
     * @test
     */
    public function that_we_can_subtract_positive_numbers()
    {
        $this->assertEquals(0, BaseCalculator::bSubtract(1, 1));
    }

    /**
     * @test
     */
    public function that_we_can_subtract_negative_numbers()
    {
        $this->assertEquals(0, BaseCalculator::bSubtract(-1, -1));
    }

    /**
     * @test
     */
    public function that_we_can_multiply_positive_numbers()
    {
        $this->assertEquals(4, BaseCalculator::bMultiply(2, 2));
    }

    /**
     * @test
     */
    public function that_we_can_multiply_negative_numbers()
    {
        $this->assertEquals(4, BaseCalculator::bMultiply(-2, -2));
    }

    /**
     * @test
     */
    public function that_we_can_divide_positive_numbers()
    {
        $this->assertEquals(1, BaseCalculator::bDivide(2, 2));
    }

    /**
     * @test
     */
    public function that_we_can_divide_negative_numbers()
    {
        $this->assertEquals(1, BaseCalculator::bDivide(-2, -2));
    }

    /**
     * @test
     */
    public function that_we_can_compare_positive_numbers()
    {
        $this->assertEquals(-1, BaseCalculator::bCompare(2, 3));
    }

    /**
     * @test
     */
    public function that_we_can_compare_negative_numbers()
    {
        $this->assertEquals(1, BaseCalculator::bCompare(-2, -3));
    }

    /**
     * @test
     */
    public function that_we_can_compare_equal_numbers()
    {
        $this->assertEquals(0, BaseCalculator::bCompare(2, 2));
    }

    /**
     * @test
     */
    public function that_we_can_calculate_exponents_with_positive_base()
    {
        $this->assertEquals(8, BaseCalculator::bPow(2, 3));
    }

    /**
     * @test
     */
    public function that_we_can_calculate_exponents_with_negative_base()
    {
        $this->assertEquals(-8, BaseCalculator::bPow(-2, 3));
    }

    /**
     * @test
     */
    public function that_we_can_calculate_exponents_with_positive_exponent()
    {
        $this->assertEquals(4, BaseCalculator::bPow(2, 2));
    }

    /**
     * @test
     */
    public function that_we_can_calculate_exponents_with_negative_exponent()
    {
        $this->assertEquals(0.25, BaseCalculator::bPow(2, -2));
    }
}
