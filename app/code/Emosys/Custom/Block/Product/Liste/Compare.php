<?php

namespace Emosys\Custom\Block\Product\Liste;

use Magento\Catalog\Model\Product;
use Magento\Customer\Model\Context;
use Magento\Framework\App\Action\Action;

class Compare extends \Magento\Catalog\Block\Product\Compare\ListCompare {
	/**
     * Retrieve Product Compare items collection
     *
     * @return \Magento\Catalog\Model\ResourceModel\Product\Compare\Item\Collection
     */
    public function getItems()
    {
        if ($this->_items === null) {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
			$this->_items = $objectManager->get('Magento\Catalog\Helper\Product\Compare')->getItemCollection();
			$this->_items->addAttributeToSelect(
                $this->_catalogConfig->getProductAttributes()
            )->loadComparableAttributes()->addMinimalPrice()->addTaxPercents()->setVisibility(
                $this->_catalogProductVisibility->getVisibleInSiteIds()
            );
            $this->_items
            	->addAttributeToSelect('price')
            	->addAttributeToSelect('short_description')
            	->addAttributeToSelect('sku')
            	->load();
        }

        return $this->_items;
    }
}