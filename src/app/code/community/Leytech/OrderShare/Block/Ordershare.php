<?php
/**
 * @package    Leytech_OrderShare
 * @author     Chris Nolan (chris@leytech.co.uk)
 * @copyright  Copyright (c) 2017 Chris Nolan
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Leytech_OrderShare_Block_Ordershare extends Mage_Checkout_Block_Onepage_Success {

    public function getOrder() {
        return Mage::getModel('sales/order')->loadByIncrementId($this->getOrderId());
    }

    public function getOrderedProduct($ordered_product) {
        return Mage::getModel('catalog/product')->load($ordered_product->getProductId());
    }

    public function getTwitterUser() {
        return trim(Mage::getStoreConfig(Leytech_OrderShare_Helper_Data::XML_PATH_TWITTER_USERNAME ));
    }

    public function getTwitterUrl($_twitter_text, $_product) {
        $_twitter_user = $this->getTwitterUser();
        $_twitter_url = "http://twitter.com/share?text=" .  urlencode ( $_twitter_text ) . "&url=" . $_product->getProductUrl();
        if ($_twitter_user != "") {
            $_twitter_url .=  "&via=" . $_twitter_user;
        }

        return $_twitter_url;
    }

    public function getFacebookUrl($_product) {
        return "http://facebook.com/sharer.php?u=" .  rawurlencode($_product->getProductUrl()) . '&t=' .  rawurlencode(Mage::getStoreConfig('general/store_information/name') .  ' | ' . $_product->getName());
    }

    public function getStoreName() {
        return Mage::getStoreConfig('general/store_information/name');
    }

    public function getColumnCount() {
        return Mage::getStoreConfig(Leytech_OrderShare_Helper_Data::XML_PATH_COLUMN_COUNT );
    }

    public function isEnabled() {
        return Mage::getStoreConfigFlag(Leytech_OrderShare_Helper_Data::XML_PATH_ENABLED );
    }
}
