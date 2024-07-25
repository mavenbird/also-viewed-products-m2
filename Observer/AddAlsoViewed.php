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
namespace Mavenbird\AlsoViewed\Observer;

use Magento\Framework\Event\ObserverInterface;

class AddAlsoViewed implements ObserverInterface
{

    /**
     * @var \Mavenbird\AlsoViewed\Helper\Data
     */
    protected $_helper;

    /**
     * @var \Magento\Catalog\Model\Session
     */
    protected $_catalogSession;

    /**
     * @var \Mavenbird\AlsoViewed\Model\View
     */
    public $alsoViewedModel;

    /**
     * Initialize constructor
     * @param \Mavenbird\AlsoViewed\Helper\Data $helper
     * @param \Magento\Catalog\Model\Session $catalogSession
     * @param \Mavenbird\AlsoViewed\Model\View $alsoViewedModel
     */
    public function __construct(
        \Mavenbird\AlsoViewed\Helper\Data $helper,
        \Magento\Catalog\Model\Session $catalogSession,
        \Mavenbird\AlsoViewed\Model\View $alsoViewedModel
    ) {
        $this->_helper = $helper;
        $this->_catalogSession = $catalogSession;
        $this->alsoViewedModel = $alsoViewedModel;
    }

    /**
     * Log out user and redirect to new admin custom url
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {

        $product = $observer->getEvent()->getProduct();
        $getSession = $this->_catalogSession->getMosViewUser();
        if (!isset($getSession)) {
            $cusSession = $this->_helper->generateRandomString();
            $this->_catalogSession->setMosViewUser($cusSession);
            $getSession = $cusSession;
        }
        $id = $product->getId();
        $name = $product->getName();
        $sku = $product->getSku();
        $ip = filter_input(
            INPUT_SERVER,
            'REMOTE_ADDR',
            FILTER_UNSAFE_RAW
        );
        $model = $this->alsoViewedModel;

        if ($this->_catalogSession->getData($getSession) == null) {
            $userProductViewArray = [];
            array_push($userProductViewArray, $id);

            $this->_catalogSession
                    ->setData($getSession, $userProductViewArray);
            $model->setSessionCode($getSession);
            $model->setProductId($id);
            $model->setProductSku($sku);
            $model->setIp($ip);
            $model->save();
        } else {
            $getSessionData = [];
            $getSessionData = $this->_catalogSession->getData($getSession);
            if (!in_array($id, $getSessionData)) {
                array_push($getSessionData, $id);
                $this->_catalogSession->getData($getSession, $getSessionData);
                $model->setSessionCode($getSession);
                $model->setProductId($id);
                $model->setProductSku($sku);
                $model->setIp($ip);
                $model->save();
            }

        }
    }
}
