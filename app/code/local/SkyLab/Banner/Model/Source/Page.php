<?php

/**
 * Class SkyLab_Banner_Model_Source_Page
 */
class SkyLab_Banner_Model_Source_Page
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
            SkyLab_Banner_Helper_Data::BANNER_TYPE_CMS => $_helper->__('Cms Page'),
            SkyLab_Banner_Helper_Data::BANNER_TYPE_CATEGORY => $_helper->__('Category Page'),
            SkyLab_Banner_Helper_Data::BANNER_TYPE_PRODUCT => $_helper->__('Product Page'),
            SkyLab_Banner_Helper_Data::BANNER_TYPE_CATALOGSEARCH => $_helper->__('Catalog Search Page')
        );
    }

}
