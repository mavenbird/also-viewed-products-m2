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
namespace Mavenbird\AlsoViewed\Model;

/**
 * @method View setSessionCode($sessionCode)
 * @method View setProductId($productId)
 * @method View setProductSku($productSku)
 * @method View setIp($ip)
 * @method mixed getSessionCode()
 * @method mixed getProductId()
 * @method mixed getProductSku()
 * @method mixed getIp()
 * @method View setCreatedAt(\string $createdAt)
 * @method string getCreatedAt()
 * @method View setUpdatedAt(\string $updatedAt)
 * @method string getUpdatedAt()
 */
class View extends \Magento\Framework\Model\AbstractModel
{

    public const CACHE_TAG = 'mavenbird_alsoviewed_view';

    /**
     * cache tag of the model
     *
     * @var string
     */
    protected $_cacheTag = 'mavenbird_alsoviewed_view';

    /**
     * Event prefix of the model
     *
     * @var string
     */
    protected $_eventPrefix = 'mavenbird_alsoviewed_view';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Mavenbird\AlsoViewed\Model\ResourceModel\View::class);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get entity default values
     *
     * @return array
     */
    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}
