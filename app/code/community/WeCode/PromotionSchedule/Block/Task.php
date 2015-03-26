<?php
/**
 * Who:  Alvin Nguyen
 * When: 23/03/15
 * Why:  
 */
class WeCode_PromotionSchedule_Block_Task extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct()
    {
        $this->_blockGroup      = 'wecode_promotionschedule';
        $this->_controller      = 'task';
        $this->_headerText      = $this->__('Promotion Schedule');
        $this->_addButtonLabel  = $this->__('Add new schedule');
        parent::__construct();
            }

    public function getCreateUrl()
    {
        return $this->getUrl('*/*/new');
    }

}

