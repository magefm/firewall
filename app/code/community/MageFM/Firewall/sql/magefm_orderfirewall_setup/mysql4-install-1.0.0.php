<?php

/** @var Mage_Core_Model_Resource_Setup $this */
$this->startSetup();

$table = $this->getConnection()
    ->newTable($this->getTable('magefm_firewall/restriction_ip'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_BIGINT, null, array(
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
    ))
    ->addColumn('ip', Varien_Db_Ddl_Table::TYPE_VARCHAR, 32, array(
        'nullable' => false,
    ))
    ->addColumn('added_at', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'nullable' => false,
    ));

$this->getConnection()->createTable($table);

$this->endSetup();
