<?php

/**
 * Class SkyLab_Banner_Block_Adminhtml_Group_Edit_Tab_Banners
 */
class SkyLab_Banner_Block_Adminhtml_Group_Edit_Tab_Banners extends Mage_Adminhtml_Block_Widget_Grid
{

    /**
     * Set grid params
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('bannersGrid');
        $this->setUseAjax(true);
        $this->setDefaultSort('id');
        $this->setDefaultFilter(array(
                'in_banners' => 1,
                'is_active' => SkyLab_Banner_Helper_Data::STATUS_ENABLED
            )
        );
        $this->setSaveParametersInSession(false);
    }

    /**
     * Retrieve currently edited banner group
     *
     * @return SkyLab_Banner_Model_Group
     */
    protected function _getCurrentGroup()
    {
        return Mage::registry('current_banner_group');
    }

    /**
    * Prepare Collection
    *
    * @return Mage_Adminhtml_Block_Widget_Grid
    */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('skylab_banner/banner')->getCollection();

        if($this->_getCurrentGroup()) {
            $collection->getSelect()->joinLeft(
                array('group_banner' => Mage::getSingleton('core/resource')->getTableName('skylab_banner/group_banner')),
                "group_banner.banner_id = main_table.id AND group_id = '" . $this->_getCurrentGroup()->getId() . "'",
                array('position')
            );
        }

        $collection->addFieldToFilter('is_active', 1);

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * Add filter
     *
     * @param object $column
     * @return SkyLab_Banner_Block_Adminhtml_Group_Edit_Tab_Banners
     */
    protected function _addColumnFilterToCollection($column)
    {
        // Set custom filter for in banners flag
        if ($column->getId() == 'in_banners') {
            $ids = $this->_getSelectedBanners();
            if (empty($ids)) {
                $ids = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('id', array('in'=>$ids));
            } else {
                if($ids) {
                    $this->getCollection()->addFieldToFilter('id', array('nin'=>$ids));
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    /**
     * Prepare columns
     *
     * @return $this
     */
    protected function _prepareColumns()
    {
        $this->addColumn('in_banners', array(
            'header_css_class'  => 'a-center',
            'type'              => 'checkbox',
            'name'              => 'banners',
            'values'            => $this->_getSelectedBanners(),
            'align'             => 'center',
            'index'             => 'id'
        ));
        $this->addColumn('id', array(
            'header' => Mage::helper('skylab_banner')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'id',
        ));
        $this->addColumn('title', array(
            'header' => Mage::helper('skylab_banner')->__('Title'),
            'align' => 'left',
            'index' => 'title',
        ));
        $this->addColumn('is_active', array(
            'header' => Mage::helper('skylab_banner')->__('Status'),
            'align' => 'center',
            'index' => 'is_active',
            'type' => 'options',
            'options' => Mage::getModel('skylab_banner/source_status')->toOptionArray(),
            'width' => '100px',
        ));
        $this->addColumn('position', array(
            'header'            => Mage::helper('skylab_banner')->__('Position'),
            'name'              => 'position',
            'width'             => 60,
            'type'              => 'number',
            'validate_class'    => 'validate-number',
            'index'             => 'position',
            'editable'          => true,
            'edit_only'         => true
        ));

        return parent::_prepareColumns();
    }

    /**
     * Get Grid Url
     *
     * @return mixed|string
     */
    public function getGridUrl()
    {
        return $this->_getData('grid_url') ? $this->_getData('grid_url') : $this->getUrl('*/*/bannersgrid', array('_current'=>true));
    }

    /**
     * Get Selected Banners
     *
     * @return array
     */
    protected function _getSelectedBanners()
    {
        $banners = $this->getGroupBanners();
        if (!is_array($banners)) {
            $banners = array_keys($this->getSelectedBanners());
        }

        return $banners;
    }

    /**
     * Get Selected Banners
     *
     * @return array
     */
    public function getSelectedBanners()
    {
        $banners  = array();

        $group = $this->_getCurrentGroup();
        if($group) {
            foreach ($group->getSelectedBanners() as $banner) {
                $banners[$banner->getId()] = array('position' => $banner->getPosition());
            }
        }

        return $banners;
    }

}
