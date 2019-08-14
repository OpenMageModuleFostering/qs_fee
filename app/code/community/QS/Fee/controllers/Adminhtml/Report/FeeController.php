<?php

class QS_Fee_Adminhtml_Report_FeeController extends Mage_Adminhtml_Controller_Action
{

    public function _initAction()
    {

        $this->loadLayout()
            ->_addBreadcrumb(Mage::helper('fee')->__('Upic'), Mage::helper('fee')->__('Upic'));
        return $this;
    }

    public function simpleAction()
    {
        $this->_title($this->__('fee'))->_title($this->__('Reports'))->_title($this->__('Simple Report'));

        $this->_initAction()
            ->_setActiveMenu('fee/report')
            ->_addBreadcrumb(Mage::helper('fee')->__('Simple Example Report'), Mage::helper('fee')->__('Simple Example Report'))
            ->_addContent($this->getLayout()->createBlock('fee/adminhtml_report_simple'))
            ->renderLayout();

    }

    public function exportSimpleCsvAction()
    {
        $fileName   = 'simple.csv';
        $content    = $this->getLayout()->createBlock('fee/adminhtml_report_simple_grid')
            ->getCsv();

        $this->_prepareDownloadResponse($fileName, $content);
    }

}