<?php
/**
 * Copyright © 2016 Ihor Vansach (ihor@magefan.com). All rights reserved.
 * See LICENSE.txt for license details (http://opensource.org/licenses/osl-3.0.php).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Emosys\Slidere\Model\ResourceModel;

/**
 * Blog category resource model
 */
class Slider extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    
    /**
     * 
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param type $resourcePrefix
     * @return \Emosys\Slidere\Model\ResourceModel\Slider
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        $resourcePrefix = null
    ) {
        parent::__construct($context, $resourcePrefix);
        return $this;
    }

    /**
     * 
     * @return \Emosys\Slidere\Model\ResourceModel\Slider
     */
    protected function _construct() {
        $this->_init('emosys_slider', 'slider_id');
        return $this;
    }
}
