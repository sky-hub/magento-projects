<?php

/**
 * Class SkyLab_Surcharge_Model_Total_Quote
 */
class SkyLab_Surcharge_Model_Total_Quote extends Mage_Sales_Model_Quote_Address_Total_Abstract
{

    /**
     * Initialize model
     */
    public function __construct()
    {
        $this->setCode('night_hours_surcharge');
    }

    /**
     * Retrieve helper
     *
     * @return SkyLab_Surcharge_Helper_Data
     */
    protected function _getHelper()
    {
        return Mage::helper('skylab_surcharge');
    }

    /**
     * Collect night hours surcharge
     *
     * @param Mage_Sales_Model_Quote_Address $address
     * @return SkyLab_Surcharge_Model_Total_Quote
     */
    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        $quote = $address->getQuote();
        $storeId = $quote->getStore()->getId();

        // check if night hours are enabled
        if (!$this->_getHelper()->isEnabled($storeId)) {
            return $this;
        }

        $multiplier = 0;
        $nightHours = $this->_getHelper()->getNightHours($storeId);
        foreach ($quote->getAllItems() as $item) {
            foreach ($item->getProduct()->getOptions() as $option) {
                if ($option->getType() == 'date_time') {
                    $info = $item->getOptionByCode('info_buyRequest');
                    $infoBuyRequest = new Varien_Object($info ? unserialize($info->getValue()) : null);
                    $options = $infoBuyRequest->getOptions();
                    $date = $options[$option->getOptionId()];
                    $selectedDate = $date['hour'];

                    if (in_array($selectedDate, $nightHours)) {
                        $multiplier += $item->getQty() ;
                    }
                }
            }
        }

        $baseGrandTotal = $address->getBaseGrandTotal();
        $grandTotal = $address->getGrandTotal();

        if ($baseGrandTotal >= 0) {
            $baseCurrencyCode = Mage::app()->getStore()->getBaseCurrencyCode();
            $currentCurrencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();
            $baseNightHoursSurcharge = $this->_getHelper()->getAmount($storeId) * $multiplier;
            $nightHoursSurcharge = Mage::helper('directory')->currencyConvert(
                $baseNightHoursSurcharge,
                $baseCurrencyCode,
                $currentCurrencyCode
            );

            $quote->setBaseNightHoursSurcharge($baseNightHoursSurcharge);
            $quote->setNightHoursSurcharge($nightHoursSurcharge);
            $quote->getBaseGrandTotal($baseGrandTotal + $baseNightHoursSurcharge);
            $quote->getGrandTotal($grandTotal + $nightHoursSurcharge);

            $address->setBaseNightHoursSurcharge($baseNightHoursSurcharge);
            $address->setNightHoursSurcharge($nightHoursSurcharge);
            $address->setBaseGrandTotal($baseGrandTotal + $baseNightHoursSurcharge);
            $address->setGrandTotal($grandTotal + $nightHoursSurcharge);
        }

        return $this;
    }

    /**
     * Get night hours surcharge and set it to quote address
     *
     * @param Mage_Sales_Model_Quote_Address $address
     * @return SkyLab_Surcharge_Model_Total_Quote
     */
    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        $storeId = $address->getQuote()->getStore()->getId();
        // check if night hours are enabled
        if (!$this->_getHelper()->isEnabled($storeId)) {
            return $this;
        }

        if ($address->getNightHoursSurcharge()) {
            $address->addTotal(array(
                'code' => $this->getCode(),
                'title' => $this->_getHelper()->getFormattedLabel($storeId),
                'value' => $address->getNightHoursSurcharge()
            ));
        }

        return $this;
    }

}
