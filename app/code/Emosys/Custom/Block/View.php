
<?php
/**
 * Copyright © 2015 Ihor Vansach (ihor@magefan.com). All rights reserved.
 * See LICENSE.txt for license details (http://opensource.org/licenses/osl-3.0.php).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Emosys\Custom\Block;

/*
use Magento\Framework\View\Element\Template;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;
*/

/**
 * Blog index block
 */
class View extends \Magento\Catalog\Block\Product\View
{
    protected function _toHtml()
{
    $this->setModuleName($this->extractModuleName('Magento\Catalog\Block\Product\View'));
    return parent::_toHtml();
}
}
