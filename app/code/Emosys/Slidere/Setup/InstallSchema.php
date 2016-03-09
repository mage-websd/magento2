<?php
/**
 * Copyright © 2015 Ihor Vansach (ihor@magefan.com). All rights reserved.
 * See LICENSE.txt for license details (http://opensource.org/licenses/osl-3.0.php).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Emosys\Slidere\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;

/**
 * Blog setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();
        
        $sliderTable = $installer->getTable('emosys_slider');
        $sliderImageTable = $installer->getTable('emosys_slider_images');
        $installer->run("
            CREATE TABLE IF NOT EXISTS `{$sliderTable}`(
  `slider_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `enable` tinyint(1) NOT NULL DEFAULT '1',
  `data` text NULL,
  `description` text NULL,
  PRIMARY KEY (`slider_id`),
  UNIQUE KEY `UNIQUE_CODE` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
");
$installer->run("
CREATE TABLE IF NOT EXISTS `{$sliderImageTable}` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `slider_id` int(11) NOT NULL,
  `name_origin` varchar(255) NOT NULL,
  `name_rename` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `enable` tinyint(1) NOT NULL DEFAULT '1',
  `path` text NOT NULL,
  `description` text NULL,
  `link` varchar(255) NOT NULL,
  `position` int(5) NOT NULL,
  PRIMARY KEY (`image_id`),
  KEY `FOREIGNKEY_SLIDER_IMAGES` (`slider_id`),
  CONSTRAINT `FOREIGNKEY_SLIDER_IMAGES` FOREIGN KEY (`slider_id`) REFERENCES `sliderg_slider` (`slider_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
                ");
        $installer->endSetup();
    }
}
