<?php
/**
 * Mavenbird Technologies Private Limited
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://mavenbird.com/Mavenbird-Module-License.txt
 *
 * =================================================================
 *
 * @category   Mavenbird
 * @package    Mavenbird_AlsoViewed
 * @author     Mavenbird Team
 * @copyright  Copyright (c) 2018-2024 Mavenbird Technologies Private Limited ( http://mavenbird.com )
 * @license    http://mavenbird.com/Mavenbird-Module-License.txt
 */
?>
<?php

namespace Mavenbird\AlsoViewed\Model\Config\Source;

class Categories extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{

    /**
     * @var  \Magento\Catalog\Model\CategoryFactory
     */
    protected $_categorycollection;

    /**
     * Initialize constructor
     * @param \Magento\Catalog\Model\CategoryFactory $categoryFactory
     */
    public function __construct(
        \Magento\Catalog\Model\CategoryFactory $categoryFactory
    ) {
        $this->_categorycollection = $categoryFactory;
    }

    /**
     *  Get all category options
     *
     * @return array
     */
    public function getAllOptions()
    {
        $catcollection = $this->getCategoryCollection();
        $this->_options = [];
        if (!$this->_options) {
            foreach ($catcollection as $val) {
                if ($val->getEntityId() > 2) {
                    $this->_options[] = [
                        'value' => $val->getEntityId(),
                        'label' => $val->getName(),
                    ];
                }
            }
        }
        return $this->_options;
    }

    /**
     * Get category collection
     *
     * @return object
     */
    public function getCategoryCollection()
    {
        $category = $this->_categorycollection->create()
                ->getCollection()
                ->addAttributeToSelect('name');
        return $category;
    }
}
