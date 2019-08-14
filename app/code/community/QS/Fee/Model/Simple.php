<?php

class QS_Fee_Model_Simple extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        parent::_construct();
        $this->_init('fee/simple');
    }
}