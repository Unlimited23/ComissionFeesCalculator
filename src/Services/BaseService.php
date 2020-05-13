<?php

namespace App\Services;

/**
 * Service for some of the configuration properties from input.ini file.
 *
 * @author Petyo Ruzhin
 */
class BaseService
{
    private $defaultCurrency;

    private $conversionRates;

    private $validCurrencies;

    public function __construct()
    {
        $config = FileService::readConfigInput();
        
        $defaultCurrency = isset($config['DefaultCurrency']) ? $config['DefaultCurrency'] : null;
        $conversionRates = isset($config['ConversionRates']) ? $config['ConversionRates'] : null;
        $validCurrencies = isset($config['ValidCurrencies']) ? $config['ValidCurrencies'] : null;

        $this->setDefaultCurrency($defaultCurrency);
        $this->setConversionRates($conversionRates);
        $this->setValidCurrencies($validCurrencies);
    }

    public function getDefaultCurrency()
    {
        return $this->defaultCurrency;
    }

    public function getConversionRates()
    {
        return $this->conversionRates;
    }

    public function getValidCurrencies()
    {
        return $this->validCurrencies;
    }

    protected function setDefaultCurrency($defaultCurrency)
    {
        $this->defaultCurrency = $defaultCurrency;
    }

    protected function setConversionRates($conversionRates)
    {
        $this->conversionRates = $conversionRates;
    }

    protected function setValidCurrencies($validCurrencies)
    {
        $this->validCurrencies = $validCurrencies;
    }
}
