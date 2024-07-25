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
namespace Mavenbird\AlsoViewed\Helper;

use Magento\Catalog\Model\ProductCategoryList;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Catalog\Model\Session
     */
    protected $_catalogSession;

    /**
     * @var \Magento\Catalog\Model\CategoryFactory
     */
    protected $_categoryFactory;

    /**
     * @var ProductCategoryList
     */
    public $productCategory;

    /**
     * @var \Mavenbird\AlsoViewed\Model\View
     */
    public $alsoViewedModel;

    /**
     * Constructor
     *
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param \Magento\Catalog\Model\Session $catalogSession
     * @param \Magento\Catalog\Model\CategoryFactory $categoryFactory
     * @param ProductCategoryList $productCategory
     * @param \Mavenbird\AlsoViewed\Model\View $alsoViewedModel
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Catalog\Model\Session $catalogSession,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        ProductCategoryList $productCategory,
        \Mavenbird\AlsoViewed\Model\View $alsoViewedModel
    ) {
        $this->_catalogSession = $catalogSession;
        $this->_categoryFactory = $categoryFactory;
        $this->productCategory = $productCategory;
        $this->alsoViewedModel = $alsoViewedModel;
        parent::__construct($context);
    }

    /**
     * Return  config value by key and store
     *
     * @param string $key
     * @return string|null
     */
    public function getConfig($key)
    {
        $result = $this->scopeConfig->getValue(
            $key,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        return $result;
    }
    
    /**
     * Generate Random String
     *
     * @param int $length
     * @return string
     */
    public function generateRandomString($length = 5)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRS'
                . 'TUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString.time();
    }

    /**
     * Get all the category id
     *
     * @param int $productId
     * @return array
     */
    public function getCategoryIds(int $productId)
    {
        $categoryIds = $this->productCategory->getCategoryIds($productId);
        $category = [];
        if ($categoryIds) {
            $category = array_unique($categoryIds);
        }
        return $category;
    }

    /**
     * Last View product
     *
     * @param string $proSku
     * @param int $catId
     * @return array
     */
    public function lastviewproduct($proSku, $catId)
    {
        $category = explode(",", $this->getConfig('alsoviewedsection/alsoviewedgroup/applytocategory'));
        $productSkuCount = [];
        $userSession = $this->_catalogSession->getMosViewUser();
        $model = $this->alsoViewedModel;
        $connection = $model->getCollection();
        $connection->addFieldToFilter('product_sku', $proSku);
        $connection->addFieldToFilter(
            'session_code',
            ['neq'=>$userSession]
        );
        $allData = $connection->getData();

        $productSession = [];
        foreach ($allData as $data) {
            $connectionData = $model->getCollection();
            $connectionData->addFieldToFilter(
                'session_code',
                $data['session_code']
            );
            $connectionData->addFieldToFilter(
                'product_sku',
                ['neq'=>$proSku]
            );
            $connectionData->getData();
            array_push($productSession, $connectionData->getData());
        }
        $productSkuArray = [];
        foreach ($productSession as $key => $prodctData) {
            foreach ($prodctData as $stepProdct) {
                if ($this->getConfig('alsoviewedsection/alsoviewedgroup/productviewoption') == "1") {
                    $catDataid = $this->getCategoryIds($stepProdct['product_id']);
                    $result = array_intersect($catId, $catDataid);
                    if (!empty($result)) {
                        array_push(
                            $productSkuArray,
                            $stepProdct['product_id']
                        );
                    }
                } elseif ($this->getConfig('alsoviewedsection/alsoviewedgroup/productviewoption') == "2") {
                    $catDataid = $this->getCategoryIds($stepProdct['product_id']);
                    $result = array_intersect($category, $catDataid);
                    if (!empty($result)) {
                        array_push(
                            $productSkuArray,
                            $stepProdct['product_id']
                        );
                    }
                } elseif ($this->getConfig('alsoviewedsection/alsoviewedgroup/productviewoption') == "3") {
                    $parent = [];
                    foreach ($catId as $c) {
                        $category = $this->_categoryFactory->create()->load($c);
                        $parent[] = $category->getParentId($c);
                    }
                    $catId = array_diff($catId, $parent);
                    $catDataid = $this->getCategoryIds($stepProdct['product_id']);
                    $result = array_intersect($catId, $catDataid);
                    if (!empty($result)) {
                        array_push(
                            $productSkuArray,
                            $stepProdct['product_id']
                        );
                    }
                }
            }
        }
        $productSkuArrayMini = $productSkuArray;
        foreach ($productSkuArrayMini as $key => $procutsArray) {
                $tmp = array_count_values($productSkuArray);
                $cnt = $tmp[$procutsArray];
                $productSkuCount[$procutsArray] = $cnt;
        }
        arsort($productSkuCount);
        return $productSkuCount;
    }
}
