<?php
/**
 * Who:  Alvin Nguyen
 * When: 23/03/15
 * Why:  
 */ 
class WeCode_PromotionSchedule_Helper_Data extends Mage_Core_Helper_Abstract {
    public function getCatalogRules(){
        $result = array();
        foreach (Mage::getModel('catalogrule/rule')->getCollection() as $rule){
            $result[$rule->getId()] = $rule->getId()." _ ".$rule->getName();
        }
        return $result;
    }

    public function getCartRules(){
        $result = array();
        foreach (Mage::getModel('salesrule/rule')->getCollection() as $rule){
            $result[$rule->getId()] = $rule->getId()." _ ".$rule->getName();
        }
        return $result;
    }
}