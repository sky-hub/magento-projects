<?php

/**
 * Class SkyLab_Banner_Block_Adminhtml_Group_Edit_Tab_Cms
 */
class SkyLab_Banner_Block_Adminhtml_Group_Edit_Tab_Cms extends Mage_Adminhtml_Block_Widget_Grid
{

    /**
     * Set grid params
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('pagesGrid');
        $this->setUseAjax(true);
        $this->setDefaultSort('page_id');
        $this->setDefaultFilter(array(
                'in_pages' => 1,
                'is_active' => 1
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
        $collection = Mage::getModel('cms/page')->getCollection();
        $collection->getSelect()->joinLeft(
            array('group_cms' => Mage::getSingleton('core/resource')->getTableName('skylab_banner/group_cms')),
            "group_cms.page_id = main_table.page_id AND group_id = '" . $this->_getCurrentGroup()->getId() . "'",
            array('position')
        );
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * Add filter
     *
     * @param object $column
     * @return SkyLab_Banner_Block_Adminhtml_Group_Edit_Tab_Cms
     */
    protected function _addColumnFilterToCollection($column)
    {
        // Set custom filter for in pages flag
        if ($column->getId() == 'in_pages') {
            $ids = $this->_getSelectedPages();
            if (empty($ids)) {
                $ids = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('page_id', array('in'=>$ids));
            } else {
                if($ids) {
                    $this->getCollection()->addFieldToFilter('page_id', array('nin'=>$ids));
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
        $this->addColumn('in_pages', array(
            'header_css_class'  => 'a-center',
            'type'              => 'checkbox',
            'name'              => 'pages',
            'values'            => $this->_getSelectedPages(),
            'align'             => 'center',
            'index'             => 'page_id'
        ));
        $this->addColumn('page_id', array(
            'header' => Mage::helper('skylab_banner')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'page_id',
        ));
        $this->addColumn('title', array(
            'header' => Mage::helper('skylab_banner')->__('Title'),
            'align' => 'left',
            'index' => 'title',
        ));
        $this->addColumn('identifier', array(
            'header' => Mage::helper('skylab_banner')->__('Url Key'),
            'align' => 'left',
            'index' => 'identifier',
        ));
        $this->addColumn('root_template', array(
            'header' => Mage::helper('skylab_banner')->__('Layout'),
            'align' => 'left',
            'index' => 'root_template',
        ));
        $this->addColumn('is_active', array(
            'header' => Mage::helper('skylab_banner')->__('Is Active'),
            'align' => 'center',
            'index' => 'is_active',
            'type' => 'options',
            'options' => array(
                0 => Mage::helper('skylab_banner')->__('No'),
                1 => Mage::helper('skylab_banner')->__('Yes')
            ),
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
        return $this->_getData('grid_url') ? $this->_getData('grid_url') : $this->getUrl('*/*/cmsgrid', array('_current'=>true));
    }

    /**
     * Get Selected Pages
     *
     * @return array
     */
    protected function _getSelectedPages()
    {
        $pages = $this->getGroupPages();
        if (!is_array($pages)) {
            $pages = array_keys($this->getSelectedPages());
        }

        return $pages;
    }

    /**
     * Get Selected Pages
     *
     * @return array
     */
    public function getSelectedPages()
    {
        $pages = array();
        foreach ($this->_getCurrentGroup()->getSelectedPages() as $page) {
            $pages[$page->getPageId()] = array('position' => $page->getPosition());
        }

        return $pages;
    }

}
