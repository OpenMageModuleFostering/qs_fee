<?php

class QS_Fee_Model_Resource_Tiers extends Mage_Core_Model_Mysql4_Abstract
{

    public function _construct()
    {
        $this->_init('fee/table_tiers', 'tiers_id');
    }

}