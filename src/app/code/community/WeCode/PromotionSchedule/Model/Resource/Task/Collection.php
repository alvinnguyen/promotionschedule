<?php
/**
 * Who:  Alvin Nguyen
 * When: 23/03/15
 * Why:  
 */ 
class WeCode_PromotionSchedule_Model_Resource_Task_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    protected function _construct()
    {
        $this->_init('wecode_promotionschedule/task');
    }

}