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
namespace Mavenbird\AlsoViewed\ViewModel;

class AlsoViewed implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    
    /**
     * @var \Mavenbird\AlsoViewed\Helper\Data
     */
    private $helper;

    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    private $productModel;

    /**
     * @var \Magento\Catalog\Helper\Output
     */
    private $outputHelper;

    /**
     * @var \Magento\Catalog\Helper\Image
     */
    private $imageHelper;

    /**
     * @var \Magento\Catalog\Block\Product\ListProduct
     */
    private $listProduct;

    /**
     * Initialize constructor
     * @param \Mavenbird\AlsoViewed\Helper\Data $helper
     * @param \Magento\Catalog\Model\ProductFactory $productModel
     * @param \Magento\Catalog\Helper\Output $outputHelper
     * @param \Magento\Catalog\Helper\Image $imageHelper
     * @param \Magento\Catalog\Block\Product\ListProduct $listProduct
     */
    public function __construct(
        \Mavenbird\AlsoViewed\Helper\Data $helper,
        \Magento\Catalog\Model\ProductFactory $productModel,
        \Magento\Catalog\Helper\Output $outputHelper,
        \Magento\Catalog\Helper\Image $imageHelper,
        \Magento\Catalog\Block\Product\ListProduct $listProduct
    ) {
        $this->helper = $helper;
        $this->productModel = $productModel;
        $this->outputHelper = $outputHelper;
        $this->imageHelper = $imageHelper;
        $this->listProduct = $listProduct;
    }

    /**
     * Get helper
     *
     * @return \Mavenbird\AlsoViewed\Helper\Data
     */
    public function getHelper()
    {
        return $this->helper;
    }

    /**
     * Get Catalog Output helper
     *
     * @return \Magento\Catalog\Helper\Output
     */
    public function getOutputHelper()
    {

        return $this->outputHelper;
    }

    /**
     * Get Catalog Image helper
     *
     * @return \Magento\Catalog\Helper\Image
     */
    public function getImageHelper()
    {

        return $this->imageHelper;
    }

    /**
     * Get Product
     *
     * @param int $id
     * @return object
     */
    public function getProduct($id)
    {

        return $this->productModel->create()->load($id);
    }

    /**
     * Get ListProduct block
     *
     * @return \Magento\Catalog\Block\Product\ListProduct
     */
    public function getListProduct()
    {
        return $this->listProduct;
    }
}
