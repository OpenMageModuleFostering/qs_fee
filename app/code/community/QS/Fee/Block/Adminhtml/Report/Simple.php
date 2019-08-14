<?php

class QS_Fee_Block_Adminhtml_Report_Simple extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'fee';
        $this->_controller = 'adminhtml_report_simple';
        $this->_headerText = Mage::helper('fee')->__('Order with U-PIC Insurance');
        parent::__construct();
        $this->_removeButton('add');
    }
}