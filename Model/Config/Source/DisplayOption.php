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
namespace Mavenbird\AlsoViewed\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class DisplayOption implements ArrayInterface
{
    /**
     * To option array
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            [
                'value' => '1',
                'label' => __('Show Products from Current Product Category Only')
            ],
            [
                'value' => '3',
                'label' => __('Show Child Category Products from Current Product')
            ],
            [
                'value' => '2',
                'label' => __('Show Products from Selected Categories Only')
            ],
        ];
        return $options;
    }
}
