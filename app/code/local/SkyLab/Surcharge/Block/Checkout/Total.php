<?php

/**
 * Class SkyLab_Surcharge_Block_Checkout_Total
 */
class SkyLab_Surcharge_Block_Checkout_Total extends Mage_Checkout_Block_Total_Default
{

    /**
     * Template file
     *
     * @var string
     */
    protected $_template = 'skylab/surcharge/checkout/total.phtml';

    /**
     * Get data helper
     *
     * @return SkyLab_Surcharge_Helper_Data
     */
    protected function _getHelper()
    {
        return Mage::helper('skyLab_surcharge');
    }

}
