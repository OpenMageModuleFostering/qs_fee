<?php

$installer = $this;

$installer->startSetup();

$installer->run("

		ALTER TABLE  `".$this->getTable('sales/quote_address')."` add  `insurance_status` BOOLEAN DEFAULT FALSE;
		");

$installer->endSetup();
