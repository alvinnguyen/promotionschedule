<?php
/**
 * Who:  Alvin Nguyen
 * When: 23/03/15
 * Why:  
 */ 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('wecode_promotionschedule/wecode_tasks'))
    ->addColumn('wecode_tasks_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable' => false,
        'primary'  => true,
    ), 'Task Id')
    ->addColumn('wecode_tasks_title', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false
    ), 'Title')
    ->addColumn('wecode_tasks_description', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => false
    ), 'Description')
    ->addColumn('wecode_tasks_status', Varien_Db_Ddl_Table::TYPE_SMALLINT, 1, array(
        'nullable' => false
    ), 'Status')
    ->addColumn('wecode_tasks_execution', Varien_Db_Ddl_Table::TYPE_SMALLINT, 1, array(
        'nullable' => false
    ), 'Execution')
    ->addColumn('wecode_tasks_time', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'nullable' => false
    ), 'Task Time')
    ->addColumn('wecode_tasks_type', Varien_Db_Ddl_Table::TYPE_SMALLINT, 1, array(
        'nullable' => false
    ), 'Task Type')
    ->addColumn('wecode_tasks_catalog_rule_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable' => false
    ), 'Catalog Rule ID')
    ->addColumn('wecode_tasks_cart_rule_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable' => false
    ), 'Cart Rule ID');

$installer->getConnection()->createTable($table);

$installer->endSetup();