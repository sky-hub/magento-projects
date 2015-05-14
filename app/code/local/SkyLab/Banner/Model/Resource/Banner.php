<?php

/**
 * Class SkyLab_Banner_Model_Resource_Banner
 */
class SkyLab_Banner_Model_Resource_Banner extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Set main entity table name and primary key field name
     */
    protected function _construct()
    {
        $this->_init('skylab_banner/banner', 'id');
    }

}