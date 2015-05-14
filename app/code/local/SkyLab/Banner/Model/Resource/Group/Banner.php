<?php

/**
 * Class SkyLab_Banner_Model_Resource_Group_Banner
 */
class SkyLab_Banner_Model_Resource_Group_Banner extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * Resource initialization
     */
    protected function  _construct()
    {
        $this->_init('skylab_banner/group_banner', 'group_id');
    }

    /**
     * Save Group Banners
     *
     * @param $group
     * @param $data
     * @return SkyLab_Banner_Model_Resource_Group_Banner
     */
    public function saveGroupBanners($group, $data)
    {
        if (!is_array($data)) {
            $data = array();
        }
        $deleteCondition = $this->_getWriteAdapter()->quoteInto('group_id=?', $group->getId());
        $this->_getWriteAdapter()->delete($this->getMainTable(), $deleteCondition);

        foreach ($data as $bannerId => $position) {
            if (!empty($bannerId)) {
                $this->_getWriteAdapter()->insert($this->getMainTable(), array(
                    'group_id' => $group->getId(),
                    'banner_id' => $bannerId,
                    'position' => $position['position']
                ));
            }
        }

        return $this;
    }

}
