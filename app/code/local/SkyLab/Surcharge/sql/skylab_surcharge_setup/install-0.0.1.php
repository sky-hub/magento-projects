<?php

/* @var $installer Mage_Sales_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/**
 * Add quote attributes
 */
$installer->addAttribute('quote', 'base_night_hours_surcharge', array('type' => Varien_Db_Ddl_Table::TYPE_DECIMAL));
$installer->addAttribute('quote', 'night_hours_surcharge', array('type' => Varien_Db_Ddl_Table::TYPE_DECIMAL));

/**
 * Add quote address attributes
 */
$installer->addAttribute('quote_address', 'base_night_hours_surcharge', array('type' => Varien_Db_Ddl_Table::TYPE_DECIMAL));
$installer->addAttribute('quote_address', 'night_hours_surcharge', array('type' => Varien_Db_Ddl_Table::TYPE_DECIMAL));

/**
 * Add order attributes
 */
$installer->addAttribute('order', 'base_night_hours_surcharge', array('type' => Varien_Db_Ddl_Table::TYPE_DECIMAL));
$installer->addAttribute('order', 'night_hours_surcharge', array('type' => Varien_Db_Ddl_Table::TYPE_DECIMAL));

/**
 * Add invoice attributes
 */
$installer->addAttribute('invoice', 'base_night_hours_surcharge', array('type' => Varien_Db_Ddl_Table::TYPE_DECIMAL));
$installer->addAttribute('invoice', 'night_hours_surcharge', array('type' => Varien_Db_Ddl_Table::TYPE_DECIMAL));

/**
 * Add creditmemo attributes
 */
$installer->addAttribute('creditmemo', 'base_night_hours_surcharge', array('type' => Varien_Db_Ddl_Table::TYPE_DECIMAL));
$installer->addAttribute('creditmemo', 'night_hours_surcharge', array('type' => Varien_Db_Ddl_Table::TYPE_DECIMAL));

/**
 * End Setup
 */
$installer->endSetup();
