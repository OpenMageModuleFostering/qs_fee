<?php

class QS_Fee_Model_Resource_Tiers_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{

    public function _construct()
    {
        parent::_construct();
        $this->_init('fee/tiers');
    }

}