<?php

/**
 * Who:  Alvin Nguyen
 * When: 23/03/15
 * Why:
 */
class WeCode_PromotionSchedule_Block_Task_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'wecode_promotionschedule_id';
        parent::__construct();
        $this->_blockGroup = 'wecode_promotionschedule';
        $this->_controller = 'task';
        $this->_mode       = 'edit';
        $modelTitle        = $this->_getModelTitle();
        $this->_updateButton('save', 'label', $this->_getHelper()->__("Save $modelTitle"));
        $this->_addButton('saveandcontinue', array(
            'label'   => $this->_getHelper()->__('Save and Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class'   => 'save',
        ), -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";

        $this->_formScripts[] = "
            function showRightRule(){
                if ($('wecode_tasks_type').selectedIndex == 0 || $('wecode_tasks_type').selectedIndex == 1){
			        $('wecode_tasks_cart_rule_id').parentNode.parentNode.hide();
                    $('wecode_tasks_catalog_rule_id').parentNode.parentNode.show();
			    }else{
                    $('wecode_tasks_cart_rule_id').parentNode.parentNode.show();
                    $('wecode_tasks_catalog_rule_id').parentNode.parentNode.hide();
			    }
            }
            Event.observe(window, 'load', function(){
                showRightRule();
			});
			Event.observe($('wecode_tasks_type'), 'change', function(){
                showRightRule();
			});
        ";
    }

    protected function _getHelper()
    {
        return Mage::helper('wecode_promotionschedule');
    }

    protected function _getModel()
    {
        return Mage::registry('current_model');
    }

    protected function _getModelTitle()
    {
        return 'Task';
    }

    public function getHeaderText()
    {
        $model      = $this->_getModel();
        $modelTitle = $this->_getModelTitle();
        if ($model && $model->getId()) {
            return $this->_getHelper()->__("Edit $modelTitle (ID: {$model->getId()})");
        } else {
            return $this->_getHelper()->__("New $modelTitle");
        }
    }


    /**
     * Get URL for back (reset) button
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('*/*/index');
    }

    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', array($this->_objectId => $this->getRequest()->getParam($this->_objectId)));
    }

    /**
     * Get form save URL
     *
     * @deprecated
     * @see getFormActionUrl()
     * @return string
     */
    public function getSaveUrl()
    {
        $this->setData('form_action_url', 'save');
        return $this->getFormActionUrl();
    }


}
