<?php

/**
 * Class SkyLab_Banner_Model_Resource_Group_Product
 */
class SkyLab_Banner_Model_Resource_Group_Product extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * Resource initialization
     */
    protected function  _construct()
    {
        $this->_init('skylab_banner/group_product', 'product_id');
    }

    /**
     * Save Group Products
     *
     * @param $group
     * @param $data
     * @return $this
     */
    public function saveGroupProducts($group, $data)
    {
        if (!is_array($data)) {
            $data = array();
        }
        $deleteCondition = $this->_getWriteAdapter()->quoteInto('group_id=?', $group->getId());
        $this->_getWriteAdapter()->delete($this->getMainTable(), $deleteCondition);

        foreach ($data as $productId => $position) {
            if (!empty($productId)) {
                $this->_getWriteAdapter()->insert($this->getMainTable(), array(
                    'group_id' => $group->getId(),
                    'product_id' => $productId,
                    'position' => $position['position']
                ));
            }
        }

        return $this;
    }

}
