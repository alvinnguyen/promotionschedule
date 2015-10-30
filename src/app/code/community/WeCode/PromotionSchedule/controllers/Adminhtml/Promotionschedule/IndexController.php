<?php
/**
 * Who:  Alvin Nguyen
 * When: 23/03/15
 * Why:  
 */

class WeCode_PromotionSchedule_Adminhtml_Promotionschedule_IndexController extends Mage_Adminhtml_Controller_Action {

    public function indexAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('wecode_promotionschedule/task'));
        $this->renderLayout();
    }

    public function exportCsvAction()
    {
        $fileName = 'Task_export.csv';
        $content  = $this->getLayout()->createBlock('wecode_promotionschedule/task_grid')->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function exportExcelAction()
    {
        $fileName = 'Task_export.xml';
        $content  = $this->getLayout()->createBlock('wecode_promotionschedule/task_grid')->getExcel();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function massDeleteAction()
    {
        $ids = $this->getRequest()->getParam('ids');
        if (!is_array($ids)) {
            $this->_getSession()->addError($this->__('Please select Task(s).'));
        } else {
            try {
                foreach ($ids as $id) {
                    $model = Mage::getSingleton('wecode_promotionschedule/task')->load($id);
                    $model->delete();
                }

                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) have been deleted.', count($ids))
                );
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addError(
                    Mage::helper('wecode_promotionschedule')->__('An error occurred while mass deleting items. Please review log and try again.')
                );
                Mage::logException($e);
                return;
            }
        }
        $this->_redirect('*/*/index');
    }

    public function editAction()
    {
        $id    = $this->getRequest()->getParam('id');
        $model = Mage::getModel('wecode_promotionschedule/task');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->_getSession()->addError(
                    Mage::helper('wecode_promotionschedule')->__('This Task no longer exists.')
                );
                $this->_redirect('*/*/');
                return;
            }
        }

        $data = $this->_getSession()->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('current_model', $model);

        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('wecode_promotionschedule/task_edit'));
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function saveAction()
    {
        $redirectBack = $this->getRequest()->getParam('back', false);
        if ($data = $this->getRequest()->getPost()) {

            $id    = $this->getRequest()->getParam('id');
            $model = Mage::getModel('wecode_promotionschedule/task');
            if ($id) {
                $model->load($id);
                if (!$model->getId()) {
                    $this->_getSession()->addError(
                        Mage::helper('wecode_promotionschedule')->__('This Task no longer exists.')
                    );
                    $this->_redirect('*/*/index');
                    return;
                }
            }

            if ($data['wecode_tasks_time'] != NULL )
            {
                $date = date_create_from_format('d/m/Y h:i A', $data['wecode_tasks_time']);
                if (!$date){
                    $this->_getSession()->addError(Mage::helper('wecode_promotionschedule')->__('Error. Please ensure date is correctly entered (e.g. 03:00 PM, not 15:00 PM)'));
                    $redirectBack = true;
                }else{
                    $data['wecode_tasks_time'] = date_format($date, 'Y-m-d H:i:00');
                }
            }

            $this->_getSession()->setFormData($data);

            if ($date){
                // save model
                try {
                    $model->addData($data);
                    $model->save();
                    $this->_getSession()->setFormData(false);
                    $this->_getSession()->addSuccess(
                        Mage::helper('wecode_promotionschedule')->__('The Task has been saved.')
                    );
                } catch (Mage_Core_Exception $e) {
                    $this->_getSession()->addError($e->getMessage());
                    $redirectBack = true;
                } catch (Exception $e) {
                    $this->_getSession()->addError(Mage::helper('wecode_promotionschedule')->__('Unable to save the Task.'));
                    $redirectBack = true;
                    Mage::logException($e);
                }
            }

            if ($redirectBack) {
                $this->_redirect('*/*/edit', array('id' => $model->getId()));
                return;
            }
        }
        $this->_redirect('*/*/index');
    }

    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                // init model and delete
                $model = Mage::getModel('wecode_promotionschedule/task');
                $model->load($id);
                if (!$model->getId()) {
                    Mage::throwException(Mage::helper('wecode_promotionschedule')->__('Unable to find a Task to delete.'));
                }
                $model->delete();
                // display success message
                $this->_getSession()->addSuccess(
                    Mage::helper('wecode_promotionschedule')->__('The Task has been deleted.')
                );
                // go to grid
                $this->_redirect('*/*/index');
                return;
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addError(
                    Mage::helper('wecode_promotionschedule')->__('An error occurred while deleting Task data. Please review log and try again.')
                );
                Mage::logException($e);
            }
            // redirect to edit form
            $this->_redirect('*/*/edit', array('id' => $id));
            return;
        }
// display error message
        $this->_getSession()->addError(
            Mage::helper('wecode_promotionschedule')->__('Unable to find a Task to delete.')
        );
// go to grid
        $this->_redirect('*/*/index');
    }
}