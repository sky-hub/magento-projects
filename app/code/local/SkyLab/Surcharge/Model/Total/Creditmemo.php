<?php

/**
 * Class SkyLab_Surcharge_Model_Total_Creditmemo
 */
class SkyLab_Surcharge_Model_Total_Creditmemo extends Mage_Sales_Model_Order_Creditmemo_Total_Abstract
{
	
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
     * Collect totals for credit memo
     *
     * @param Mage_Sales_Model_Order_Creditmemo $creditmemo
     * @return SkyLab_Surcharge_Model_Total_Creditmemo
     */
    public function collect(Mage_Sales_Model_Order_Creditmemo $creditmemo)
    {
        // get order
        $order = $creditmemo->getOrder();
        $storeId = $order->getStoreId();

        if ($order->getNightHoursSurcharge()) {
            $baseCurrencyCode = Mage::app()->getStore()->getBaseCurrencyCode();
            $currentCurrencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();
            $baseNightHoursSurcharge = $this->_getHelper()->getAmount($storeId);
            $nightHoursSurcharge = Mage::helper('directory')->currencyConvert(
                $baseNightHoursSurcharge,
                $baseCurrencyCode,
                $currentCurrencyCode
            );

            $baseGrandTotal = $creditmemo->getBaseGrandTotal();
            $grandTotal = $creditmemo->getGrandTotal();

            $creditmemo->setBaseNightHoursSurcharge($baseNightHoursSurcharge);
            $creditmemo->setNightHoursSurcharge($nightHoursSurcharge);
            $creditmemo->setBaseGrandTotal($baseGrandTotal + $baseNightHoursSurcharge);
            $creditmemo->setGrandTotal($grandTotal + $nightHoursSurcharge);
        }

        return $this;
    }

}
