<?php

/**
 * Class SkyLab_Surcharge_Block_Sales_Order_Total
 */
class SkyLab_Surcharge_Block_Sales_Order_Total extends Mage_Core_Block_Template
{

    /**
     * Get data helper
     *
     * @return SkyLab_Surcharge_Helper_Data
     */
    protected function _getHelper()
    {
        return Mage::helper('skylab_surcharge');
    }

    /**
     * Get order
     *
     * @return Mage_Sales_Model_Order
     */
    public function getOrder()
    {
        return $this->getParentBlock()->getOrder();
    }

    /**
     * Get source
     *
     * @return Mage_Sales_Model_Order
     */
    public function getSource()
    {
        echo get_class($this->getParentBlock());

        return $this->getParentBlock()->getSource();
    }

    /**
     * Initialize reward points totals
     *
     * @return SkyLab_Surcharge_Block_Sales_Order_Total
     */
    public function initTotals()
    {
        if ((float)$this->getOrder()->getBaseNightHoursSurcharge()) {
            $source = $this->getSource();
            $value = $source->getNightHoursSurcharge();
            $storeId = $source->getStoreId();

            $this->getParentBlock()->addTotal(
                new Varien_Object(
                    array(
                        'code' => 'night_hours_surcharge',
                        'strong' => false,
                        'label' => $this->_getHelper()->getFormattedLabel($storeId),
                        'value' => $source instanceof Mage_Sales_Model_Order_Creditmemo ? -$value : $value
                    )
                ),
                'subtotal'
            );
        }

        return $this;
    }

}
