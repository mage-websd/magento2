<?php
namespace Emosys\Custom\Controller\Compare;

use Magento\Framework\Controller\ResultFactory;

class Index extends \Magento\Catalog\Controller\Product\Compare\Index
{
    /**
     * View blog homepage action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $this->_view->loadLayout();
        $blockCompare = $this->_view->getLayout()->createBlock('Emosys\Custom\Block\Product\Liste\Compare')->setTemplate('Magento_Catalog::product/compare/list.phtml')->toHtml();
        echo $blockCompare;
        exit;
    }

}
