<?php

$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

/**
 * DROP ALL TABLES
 *
 * Foreign keys will fail if all tables are not deleted
 */
$bannerTable = $installer->getTable('skylab_banner/banner');
$installer->getConnection()->dropTable($bannerTable);

$groupTable = $installer->getTable('skylab_banner/group');
$installer->getConnection()->dropTable($groupTable);

$groupBannerTable = $installer->getTable('skylab_banner/group_banner');
$installer->getConnection()->dropTable($groupBannerTable);

$groupStoreTable = $installer->getTable('skylab_banner/group_store');
$installer->getConnection()->dropTable($groupStoreTable);

$groupCategoryTable = $installer->getTable('skylab_banner/group_category');
$installer->getConnection()->dropTable($groupCategoryTable);

$groupProductTable = $installer->getTable('skylab_banner/group_product');
$installer->getConnection()->dropTable($groupProductTable);

$groupCmsTable = $installer->getTable('skylab_banner/group_cms');
$installer->getConnection()->dropTable($groupCmsTable);
/**
 * END TABLE DROP
 */


/**
 * Table 'skylab_banner/banner'
 */
$table = $installer->getConnection()
    ->newTable($bannerTable)
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ), 'ID')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => true,
        'default' => null
    ), 'Title')
    ->addColumn('content', Varien_Db_Ddl_Table::TYPE_TEXT, '2M', array(
        'nullable' => true,
        'default' => null
    ), 'Content')
    ->addColumn('url', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => true,
        'default' => null
    ), 'URL')
    ->addColumn('url_target', Varien_Db_Ddl_Table::TYPE_TEXT, 100, array(
        'nullable' => true,
        'default' => null
    ), 'URL Target')
    ->addColumn('button', Varien_Db_Ddl_Table::TYPE_SMALLINT, 1, array(
        'unsigned' => true,
        'nullable' => false,
        'default' => 0
    ), 'Show Button')
    ->addColumn('button_text', Varien_Db_Ddl_Table::TYPE_TEXT, 100, array(
        'nullable' => true
    ), 'Button Text')
    ->addColumn('image', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => true
    ), 'Image')
    ->addColumn('position', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'unsigned' => true,
        'nullable' => false
    ), 'Position')
    ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable' => false,
        'default' => 0,
    ), 'Is Active')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'default' => 0,
    ), 'Creation Time')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT_UPDATE
    ), 'Modification Time')
    ->setComment('Banner Table');

// Create Table
$installer->getConnection()->createTable($table);


/**
 * Table 'skylab_banner/group'
 */
$table = $installer->getConnection()
    ->newTable($groupTable)
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ), 'ID')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => true,
        'default' => null
    ), 'Title')
    ->addColumn('identifier', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => true,
        'default' => null
    ), 'Identifier')
    ->addColumn('page', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => true,
        'default' => null
    ), 'Page Type')
    ->addColumn('delay', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'unsigned' => true,
        'nullable' => false,
        'default' => '10'
    ), 'Slider Delay')
    ->addColumn('css_transition', Varien_Db_Ddl_Table::TYPE_SMALLINT, 3, array(
        'unsigned' => true,
        'nullable' => false,
        'default' => 0
    ), 'CSS3 Transition')
    ->addColumn('show_pagination', Varien_Db_Ddl_Table::TYPE_SMALLINT, 1, array(
        'unsigned' => true,
        'nullable' => false,
        'default' => 0
    ), 'Show Pagination')
    ->addColumn('lazy_load', Varien_Db_Ddl_Table::TYPE_SMALLINT, 1, array(
        'unsigned' => true,
        'nullable' => false,
        'default' => 0
    ), 'Use Lazy Load')
    ->addColumn('prev_next', Varien_Db_Ddl_Table::TYPE_SMALLINT, 1, array(
        'unsigned' => true,
        'nullable' => false,
        'default' => 0
    ), 'Show Prev Next Buttons')
    ->addColumn('position', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'unsigned' => true,
        'nullable' => false
    ), 'Position')
    ->addColumn('is_primary', Varien_Db_Ddl_Table::TYPE_SMALLINT, 1, array(
        'unsigned' => true,
        'nullable' => false,
        'default' => 0
    ), 'Is Primary Group')
    ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable' => false,
        'default' => 0,
    ), 'Is Active')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'default' => 0,
    ), 'Creation Time')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT_UPDATE
    ), 'Modification Time')
    ->setComment('Group Table');

// Create Table
$installer->getConnection()->createTable($table);


/**
 * Table 'skylab_banner/group_banner'
 */
$table = $installer->getConnection()
    ->newTable($groupBannerTable)
    ->addColumn('group_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, 11, array(
        'nullable' => false,
        'primary' => true,
    ), 'Group ID')
    ->addColumn('banner_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, 11, array(
        'nullable' => false,
        'primary' => true,
    ), 'Banner ID')
    ->addColumn('position', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'unsigned' => true,
        'nullable' => false
    ), 'Position')
    ->addIndex($installer->getIdxName('skylab_banner/group_banner', array('banner_id')),
        array('banner_id'))
    ->addForeignKey($installer->getFkName('skylab_banner/group_banner', 'group_id', 'skylab_banner/group', 'id'),
        'group_id', $installer->getTable('skylab_banner/group'), 'id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('skylab_banner/group_banner', 'banner_id', 'skylab_banner/banner', 'id'),
        'banner_id', $installer->getTable('skylab_banner/banner'), 'id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Banner Group To Banner Linkage Table');

// Create Table
$installer->getConnection()->createTable($table);


/**
 * Table 'skylab_banner/group_store'
 */
$table = $installer->getConnection()
    ->newTable($groupStoreTable)
    ->addColumn('group_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, 11, array(
        'nullable' => false,
        'primary' => true,
    ), 'Group ID')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, 11, array(
        'nullable' => false,
        'primary' => true,
    ), 'Store ID')
    ->addIndex($installer->getIdxName('skylab_banner/group_store', array('store_id')),
        array('store_id'))
    ->addForeignKey($installer->getFkName('skylab_banner/group_store', 'group_id', 'skylab_banner/group', 'id'),
        'group_id', $installer->getTable('skylab_banner/group'), 'id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('skylab_banner/group_store', 'store_id', 'core/store', 'store_id'),
        'store_id', $installer->getTable('core/store'), 'store_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Banner Group To Store Linkage Table');

// Create Table
$installer->getConnection()->createTable($table);


/**
 * Table 'skylab_banner/group_category'
 */
$table = $installer->getConnection()
    ->newTable($groupCategoryTable)
    ->addColumn('group_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, 11, array(
        'nullable' => false,
        'primary' => true,
    ), 'Group ID')
    ->addColumn('category_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, 11, array(
        'nullable' => false,
        'primary' => true,
    ), 'Banner ID')
    ->addIndex($installer->getIdxName('skylab_banner/group_category', array('category_id')),
        array('category_id'))
    ->addForeignKey($installer->getFkName('skylab_banner/group_category', 'group_id', 'skylab_banner/group', 'id'),
        'group_id', $installer->getTable('skylab_banner/group'), 'id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('skylab_banner/group_category', 'category_id', 'catalog_category_entity', 'entity_id'),
        'category_id', $installer->getTable('catalog_category_entity'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Banner Group To Category Linkage Table');

// Create Table
$installer->getConnection()->createTable($table);


/**
 * Table 'skylab_banner/group_product'
 */
$table = $installer->getConnection()
    ->newTable($groupProductTable)
    ->addColumn('group_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, 11, array(
        'nullable' => false,
        'primary' => true,
    ), 'Group ID')
    ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, 11, array(
        'nullable' => false,
        'primary' => true,
    ), 'Product ID')
    ->addColumn('position', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'unsigned' => true,
        'nullable' => false
    ), 'Position')
    ->addIndex($installer->getIdxName('skylab_banner/group_product', array('product_id')),
        array('product_id'))
    ->addForeignKey($installer->getFkName('skylab_banner/group_product', 'group_id', 'skylab_banner/group', 'id'),
        'group_id', $installer->getTable('skylab_banner/group'), 'id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('skylab_banner/group_product', 'product_id', 'catalog_product_entity', 'entity_id'),
        'product_id', $installer->getTable('catalog_product_entity'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Banner Group To Product Linkage Table');

// Create Table
$installer->getConnection()->createTable($table);


/**
 * Table 'skylab_banner/group_cms'
 */
$table = $installer->getConnection()
    ->newTable($groupCmsTable)
    ->addColumn('group_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, 11, array(
        'nullable' => false,
        'primary' => true,
    ), 'Group ID')
    ->addColumn('page_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, 11, array(
        'nullable' => false,
        'primary' => true,
    ), 'Page ID')
    ->addColumn('position', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'unsigned' => true,
        'nullable' => false
    ), 'Position')
    ->addIndex($installer->getIdxName('skylab_banner/group_cms', array('page_id')),
        array('page_id'))
    ->addForeignKey($installer->getFkName('skylab_banner/group_cms', 'group_id', 'skylab_banner/group', 'id'),
        'group_id', $installer->getTable('skylab_banner/group'), 'id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('skylab_banner/group_cms', 'page_id', 'cms/page', 'page_id'),
        'page_id', $installer->getTable('cms/page'), 'page_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Banner Group To Cms Page Linkage Table');

// Create Table
$installer->getConnection()->createTable($table);

$installer->endSetup();
