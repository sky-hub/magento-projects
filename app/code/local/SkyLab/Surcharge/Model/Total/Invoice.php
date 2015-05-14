<?php

/**
 * Class SkyLab_Surcharge_Model_Total_Invoice
 */
class SkyLab_Surcharge_Model_Total_Invoice extends Mage_Sales_Model_Order_Invoice_Total_Abstract
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
     * Collect totals for invoice
     *
     * @param Mage_Sales_Model_Order_Invoice $invoice
     * @return SkyLab_Surcharge_Model_Total_Invoice
     */
    public function collect(Mage_Sales_Model_Order_Invoice $invoice)
    {
        // get order
        $order = $invoice->getOrder();
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

            $baseGrandTotal = $invoice->getBaseGrandTotal();
            $grandTotal = $invoice->getGrandTotal();

            $invoice->setBaseNightHoursSurcharge($baseNightHoursSurcharge);
            $invoice->setNightHoursSurcharge($nightHoursSurcharge);
            $invoice->setBaseGrandTotal($baseGrandTotal + $baseNightHoursSurcharge);
            $invoice->setGrandTotal($grandTotal + $nightHoursSurcharge);
        }

        return $this;
    }

}
