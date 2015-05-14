<?php

/**
 * Class SkyLab_Banner_Model_System_Config_Source_Library
 */
class SkyLab_Banner_Model_System_Config_Source_Library
{

    /**
     * Available libraries
     *
     * @return array
     */
    public function toOptionArray()
    {
        $_helper = Mage::helper('skylab_banner');
        return array(
            SkyLab_Banner_Helper_Data::BANNER_LIBRARY_FOUNDATION => $_helper->__('Foundation'),
            SkyLab_Banner_Helper_Data::BANNER_LIBRARY_JQUERY => $_helper->__('jQuery'),
        );
    }

}
