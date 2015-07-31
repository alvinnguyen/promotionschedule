<?php
/**
 * Who:  Alvin Nguyen
 * When: 23/03/15
 * Why:  
 */ 
class WeCode_PromotionSchedule_Model_Resource_Task extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        $this->_init('wecode_promotionschedule/wecode_tasks', 'wecode_tasks_id');
    }

}