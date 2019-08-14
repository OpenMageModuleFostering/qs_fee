<?php

class QS_Fee_Adminhtml_FeeController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('fee/adminhtml_report_simple'));
        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('fee/adminhtml_report_simple_grid')->toHtml()
        );
    }

    public function exportSimpleCsvAction()
    {
        $fileName   = 'simple.csv';
        $content    = $this->getLayout()->createBlock('fee/adminhtml_report_simple_grid')
            ->getCsv();

        $this->_prepareDownloadResponse($fileName, $content);
    }

}