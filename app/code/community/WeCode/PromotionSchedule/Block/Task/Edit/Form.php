<?php

/**
 * Who:  Alvin Nguyen
 * When: 23/03/15
 * Why:
 */
class WeCode_PromotionSchedule_Block_Task_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _getModel()
    {
        return Mage::registry('current_model');
    }

    protected function _getHelper()
    {
        return Mage::helper('wecode_promotionschedule');
    }

    protected function _getModelTitle()
    {
        return 'Task';
    }

    protected function _prepareForm()
    {
        $model      = $this->_getModel();
        $modelTitle = $this->_getModelTitle();
        $form       = new Varien_Data_Form(array(
            'id'     => 'edit_form',
            'action' => $this->getUrl('*/*/save'),
            'method' => 'post'
        ));

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => $this->_getHelper()->__("$modelTitle Information"),
            'class'  => 'fieldset-wide',
        ));

        if ($model && $model->getId()) {
            $modelPk = $model->getResource()->getIdFieldName();
            $fieldset->addField($modelPk, 'hidden', array(
                'name' => $modelPk,
            ));
        }

        $fieldset->addField('wecode_tasks_title', 'text', array(
            'name'     => 'wecode_tasks_title',
            'label'    => $this->_getHelper()->__('Title'),
            'title'    => $this->_getHelper()->__('Promotion schedule title'),
            'required' => true
        ));

        $fieldset->addField('wecode_tasks_description', 'textarea', array(
            'name'     => 'wecode_tasks_description',
            'label'    => $this->_getHelper()->__('Description'),
            'title'    => $this->_getHelper()->__('Description for this promotion schedule'),
            'required' => true
        ));

        $fieldset->addField('wecode_tasks_status', 'select', array(
            'name'     => 'wecode_tasks_status',
            'label'    => $this->_getHelper()->__('Status'),
            'required' => true,
            'options'  => array(
                0 => 'Disable',
                1 => 'Enable'
            )
        ));

        $dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);

        $fieldset->addField('wecode_tasks_time', 'datetime', array(
            'name'         => 'wecode_tasks_time',
            'image'        => $this->getSkinUrl('images/grid-cal.gif'),
            'label'        => $this->_getHelper()->__('Action Time'),
            'input_format' => $dateFormatIso,
            'format'       => $dateFormatIso,
            'type'         => 'date',
            'time'         => true,
            'required'     => true,
            'style'        => 'width:150px!important'
        ));

        $fieldset->addField('wecode_tasks_type', 'select', array(
            'name'     => 'wecode_tasks_type',
            'label'    => $this->_getHelper()->__('Action'),
            'required' => true,
            'options'  => array(
                0 => 'Disable Catalog Promotion Rule',
                1 => 'Enable Catalog Promotion Rule',
                2 => 'Disable Shopping Cart Promotion Rule',
                3 => 'Enable Shopping Cart Promotion Rule'
            )
        ));

        $fieldset->addField('wecode_tasks_catalog_rule_id', 'select', array(
            'name'     => 'wecode_tasks_catalog_rule_id',
            'label'    => $this->_getHelper()->__('Catalog Promotion Rule'),
            'required' => true,
            'options'  => $this->_getHelper()->getCatalogRules()
        ));

        $fieldset->addField('wecode_tasks_cart_rule_id', 'select', array(
            'name'     => 'wecode_tasks_cart_rule_id',
            'label'    => $this->_getHelper()->__('Shopping Cart Promotion Rule'),
            'required' => true,
            'options'  => $this->_getHelper()->getCartRules()
        ));

//        $fieldset->addField('name', 'text' /* select | multiselect | hidden | password | ...  */, array(
//            'name'      => 'name',
//            'label'     => $this->_getHelper()->__('Label here'),
//            'title'     => $this->_getHelper()->__('Tooltip text here'),
//            'required'  => true,
//            'options'   => array( OPTION_VALUE => OPTION_TEXT, ),                 // used when type = "select"
//            'values'    => array(array('label' => LABEL, 'value' => VALUE), ),    // used when type = "multiselect"
//            'style'     => 'css rules',
//            'class'     => 'css classes',
//        ));
//          // custom renderer (optional)
//          $renderer = $this->getLayout()->createBlock('Block implementing Varien_Data_Form_Element_Renderer_Interface');
//          $field->setRenderer($renderer);

//      // New Form type element (extends Varien_Data_Form_Element_Abstract)
//        $fieldset->addType('custom_element','MyCompany_MyModule_Block_Form_Element_Custom');  // you can use "custom_element" as the type now in ::addField([name], [HERE], ...)


        if ($model) {
            $form->setValues($model->getData());
        }
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

}
