<?php
/**
 * Who:  Alvin Nguyen
 * When: 26/03/15
 * Why:  
 */
class WeCode_PromotionSchedule_Model_Observer{
    public function wecode_promotionschedule_cron(){
        $jobs = Mage::getModel('wecode_promotionschedule/task')->getCollection()
            ->addFieldToFilter('wecode_tasks_execution',0)
            ->addFieldToFilter('wecode_tasks_status',1)
            ->addFieldToFilter('wecode_tasks_time',array(array('lteq' => Mage::getModel('core/date')->date())));
        foreach ($jobs as $job){
            if ($job->getData('wecode_tasks_type') == 0 || $job->getData('wecode_tasks_type') == 1){
                $rule = Mage::getModel('catalogrule/rule')->load($job->getData('wecode_tasks_catalog_rule_id'));
            }else{
                $rule = Mage::getModel('salesrule/rule')->load($job->getData('wecode_tasks_cart_rule_id'));
            }
            if ($job->getData('wecode_tasks_type') == 0 || $job->getData('wecode_tasks_type') == 2 ){
                $rule->setData('is_active',0);
            }else{
                $rule->setData('is_active',1);
            }
            $rule->save();
            if ($job->getData('wecode_tasks_type') == 0 || $job->getData('wecode_tasks_type') == 1) {
                Mage::getModel('catalogrule/rule')->applyAll();
                Mage::app()->removeCache('catalog_rules_dirty');
                Mage::app()->getCacheInstance()->flush();
                Mage::app()->cleanCache();
            }
            $job = Mage::getModel('wecode_promotionschedule/task')->load($job->getId());
            $job->setData('wecode_tasks_execution',1);
            $job->save();
        }
    }
}