<?php

/**
 * Class SkyLab_Banner_Model_Source_Status
 */
class SkyLab_Banner_Model_Source_Status
{

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toOptionArray()
    {
        $_helper = Mage::helper('skylab_banner');
        return array(
            SkyLab_Banner_Helper_Data::STATUS_ENABLED => $_helper->__('Enabled'),
            SkyLab_Banner_Helper_Data::STATUS_DISABLED => $_helper->__('Disabled'),
        );
    }

}
