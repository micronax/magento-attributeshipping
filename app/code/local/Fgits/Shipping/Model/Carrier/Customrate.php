<?php

class Fgits_Shipping_Model_Carrier_Customrate extends Mage_Shipping_Model_Carrier_Abstract implements Mage_Shipping_Model_Carrier_Interface
{
    protected $_code = 'fgits_customrate';
    protected $_isFixed = true;

    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {
        if (!$this->getConfigFlag('active')) {
            return false;
        }

        if (!$destCountry = strtolower($request->getDestCountryId())) {
            return false;
        }

        $result = Mage::getModel('shipping/rate_result');

        // Some meta-information
        $method = Mage::getModel('shipping/rate_result_method');
        $method->setCarrier('fgits_customrate');
        $method->setCarrierTitle($this->getConfigData('title'));
        $method->setMethod('fgits_customrate');
        $method->setMethodTitle($this->getConfigData('name'));

        // Calculate shipping cost
        if (!$orderShippingCost = $this->determineShippgingCost($destCountry)) {
            return false;
        }

        // Set shipping cost
        $method->setPrice($orderShippingCost);
        $method->setCost($orderShippingCost);

        $result->append($method);
        return $result;
    }

    public function getAllowedMethods()
    {
        return array('fgits_customrate' => $this->getConfigData('name'));
    }

    public function determineShippgingCost($countryCode)
    {
        Mage::getSingleton('core/session', array('name'=>'frontend'));
        $session = Mage::getSingleton('checkout/session');
        $cart_items = $session->getQuote()->getAllItems();
        $_helper = Mage::helper('catalog/output');

        $fn_name = 'getShippingCost'.ucfirst($countryCode);

        $cartShippingCost = 0.0;
        foreach($cart_items as $items) {
            $cur_fproduct = Mage::getModel('catalog/product')->load($items->getProduct_id());

            if ($shippingCost = $_helper->productAttribute($cur_fproduct, $cur_fproduct->$fn_name(), 'shipping_cost'.$countryCode)) {
                if ($cartShippingCost < $shippingCost) {
                    $cartShippingCost = $shippingCost;
                }
            } else return false;
        }

        return (float) $cartShippingCost;
    }
}