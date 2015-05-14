<?php

/**
 * Class SkyLab_Surcharge_Helper_Data
 */
class SkyLab_Surcharge_Helper_Data extends Mage_Core_Helper_Abstract
{

    /**
     * Config paths
     */
    const XML_PATH_SECTION = 'SkyLab_Surcharge/';
    const XML_PATH_SECTION_GENERAL = 'general/';
    const XML_PATH_SECTION_NIGHT_HOURS = 'night_hours/';


    /**
     * Get module config for store
     *
     * @param string $field
     * @param int $storeId
     * @return string
     */
    public function getStoreConfig($field, $storeId = null)
    {
        return Mage::getStoreConfig(self::XML_PATH_SECTION . $field, $storeId);
    }

    /**
     * Get module config for website
     *
     * @param string $field
     * @param int $websiteId
     * @return string
     */
    public function getWebsiteConfig($field, $websiteId = null)
    {
        return Mage::app()->getWebsite()->getConfig(self::XML_PATH_SECTION . $field, 'website', $websiteId);
    }

    /**
     * Check if night hours is enabled
     *
     * @param $storeId
     * @return bool
     */
    public function isEnabled($storeId = null)
    {
        return (bool)$this->getStoreConfig(self::XML_PATH_SECTION_NIGHT_HOURS . 'enabled', $storeId);
    }

    /**
     * Get night hours amount
     *
     * @param $storeId
     * @return bool
     */
    public function getAmount($storeId = null)
    {
        return (int)$this->getStoreConfig(self::XML_PATH_SECTION_NIGHT_HOURS . 'amount', $storeId);
    }

    /**
     * Get night hours label
     *
     * @param $storeId
     * @return bool
     */
    public function getLabel($storeId = null)
    {
        return (string)$this->getStoreConfig(self::XML_PATH_SECTION_NIGHT_HOURS . 'label', $storeId);
    }

    /**
     * Get night hours formatted label
     *
     * @param $storeId
     * @return bool
     */
    public function getFormattedLabel($storeId = null)
    {
        return (string)$this->getLabel($storeId) . '(' . $this->getStartHour($storeId) . ' - ' . $this->getEndHour($storeId) . ')';
    }

    /**
     * Get night hours start hour
     *
     * @param $storeId
     * @return bool
     */
    public function getStartHour($storeId = null)
    {
        return (string)$this->getStoreConfig(self::XML_PATH_SECTION_NIGHT_HOURS . 'start_hour', $storeId);
    }

    /**
     * Get night hours end hour
     *
     * @param $storeId
     * @return bool
     */
    public function getEndHour($storeId = null)
    {
        return (string)$this->getStoreConfig(self::XML_PATH_SECTION_NIGHT_HOURS . 'end_hour', $storeId);
    }

    /**
     * Get night hours interval
     *
     * @param null $storeId
     * @return mixed
     */
    public function getNightHours($storeId = null)
    {
        $startHour = date('H', strtotime($this->getStartHour($storeId)));
        $endHour = date('H', strtotime($this->getEndHour($storeId)));
        $start = range($startHour, 23);
        $end = range(0, $endHour - 1);
        $nightHours = array_merge($start, $end);

        return $nightHours;
    }

}
