<?php

class QS_Fee_Model_Resource_Report_Simple_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{

    protected function _construct()
    {
        $this->_init('fee/simple');
    }

    protected function _joinFields($from = '', $to = '')
    {
        $this->addFieldToFilter('period' , array("from" => $from, "to" => $to, "datetime" => true));
        $this->getSelect()->group('description');
        $this->getSelect()->columns(array('value' => 'SUM(value)'));

        return $this;
    }

    public function setDateRange($from, $to)
    {
        $this->_reset()
            ->_joinFields($from, $to);
        return $this;
    }

    public function load($printQuery = false, $logQuery = false)
    {
        if ($this->isLoaded()) {
            return $this;
        }
        parent::load($printQuery, $logQuery);
        return $this;
    }

    public function setStoreIds($storeIds)
    {
        return $this;
    }
}