<?php
namespace Whiteapp\ShopFinder\Controller\Adminhtml\shopfinder;
/**
 * @author Mustapha <bouarfamus@gmail.com>
 */
class Delete extends \Magento\Backend\App\Action
{
    /**
     * Delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('shopfinder_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                // init model and delete
                $model = $this->_objectManager->create('Whiteapp\ShopFinder\Model\ShopFinder');
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccess(__('The Store has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['shopfinder_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('We can\'t find a Store to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
