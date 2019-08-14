<?php

    $installer = $this;

    $installer->startSetup();

    $tableName = $installer->getTable('fee/table_tiers');

    $table = $installer->getConnection()
        ->newTable($tableName)
        ->addColumn('tiers_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity'  => true,
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true,
        ), 'Tiers ID')
        ->addColumn('tier_title', Varien_Db_Ddl_Table::TYPE_VARCHAR)
        ->addColumn('domestic_value', Varien_Db_Ddl_Table::TYPE_FLOAT)
        ->addColumn('international_value', Varien_Db_Ddl_Table::TYPE_FLOAT)
        ->addColumn('code', Varien_Db_Ddl_Table::TYPE_VARCHAR);
    $installer->getConnection()->createTable($table);

    $query = "insert into $tableName (tier_title,domestic_value,international_value,code)
        values (:tier_title,:domestic_value, :international_value, :code);";

    $binds = array(
            'tier_title' => "Tier 1",
            'domestic_value' => "0.69",
            'international_value' => "1.1",
            'code' => "upichrm29800",
        );
    $installer->getConnection()->query($query,$binds);

    $binds = array(
            'tier_title' => "Tier 2",
            'domestic_value' => "0.79",
            'international_value' => "1.25",
            'code' => "upicmpv28001",
        );
    $installer->getConnection()->query($query,$binds);

    $binds = array(
            'tier_title' => "Tier 3",
            'domestic_value' => "0.99",
            'international_value' => "1.49",
            'code' => "upicds5703",
        );
    $installer->getConnection()->query($query,$binds);

$installer->endSetup();
