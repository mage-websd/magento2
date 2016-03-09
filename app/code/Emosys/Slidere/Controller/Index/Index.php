<?php

/**
 * Copyright © 2015 Ihor Vansach (ihor@magefan.com). All rights reserved.
 * See LICENSE.txt for license details (http://opensource.org/licenses/osl-3.0.php).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Emosys\Slidere\Controller\Index;

/**
 * Blog home page view
 */
class Index extends \Magento\Framework\App\Action\Action {

    protected $_slider;

    public function __construct(
            \Magento\Framework\App\Action\Context $context,
            \Emosys\Slidere\Model\Slider $slider
            ) {
        $this->_slider = $slider;
        parent::__construct($context);
    }

    /**
     * View blog homepage action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute() {
        var_dump(get_class($this->_slider));
        echo 1;

        exit;
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }

}
