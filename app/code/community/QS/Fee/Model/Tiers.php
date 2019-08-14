<?php
class QS_Fee_Model_Tiers extends Mage_Core_Model_Abstract
{

    public function _construct()
    {
        parent::_construct();
        $this->_init('fee/tiers');
    }

}