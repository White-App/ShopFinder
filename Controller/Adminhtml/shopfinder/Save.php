<?php
namespace Whiteapp\ShopFinder\Controller\Adminhtml\shopfinder;
/**
 * @author Mustapha <bouarfamus@gmail.com>
 */
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action;

class Save extends \Magento\Backend\App\Action
{

    /**
     * @param Action\Context $context
     */
    public function __construct(Action\Context $context)
    {
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $sid = $this->getRequest()->getParam('shopfinder_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($sid)
        {
            $storeid = $data['shopfinder_id'];
            $deleteid = isset($data['image']['delete'])?$data['image']['delete']:'';
            $deleteimage = isset($data['image']['value'])?$data['image']['value']:'';
            if ($deleteid != '')
            {
               $mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
               $mediaRootDir = $mediaDirectory->getAbsolutePath();
               unlink($mediaRootDir.$deleteimage);
               $imagevalue = array('image'=>'');
               $imagemodel = $this->_objectManager->get('Whiteapp\ShopFinder\Model\ShopFinder')->load($storeid)->addData($imagevalue);
               $imagemodel->setId($storeid)->save();
               $this->messageManager->addError(__('Image Delete successfully !'));
               $this->_redirect('*/*/edit', array('shopfinder_id' => $this->getRequest()->getParam('shopfinder_id'), '_current' => true));
               return;
            }
        }
        if ($data) {
            $model = $this->_objectManager->create('Whiteapp\ShopFinder\Model\ShopFinder');

            $data['image'] = isset($data['image']['value'])?$data['image']['value']:'';
            if($data['image_exists'] != 0) {
              try{
                    $uploader = $this->_objectManager->create(
                        'Magento\MediaStorage\Model\File\Uploader',
                        ['fileId' => 'image']
                    );
                    //echo "string=>".$data['image_exists'];exit();
                    $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                    $mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')->getDirectoryRead(DirectoryList::MEDIA);
                    // save the image to media directory
                    $result = $uploader->save($mediaDirectory->getAbsolutePath('storeimages/'));
                    //echo "<pre>";print_r($result);exit();
                    $base_path=$mediaDirectory->getAbsolutePath('storeimages/').$result['file'];
                    $id = $this->getRequest()->getParam('shopfinder_id');
                    if($id)
                    {
                        $data['image'] = 'storeimages/'.$result['file'];
                    }
                    else
                    {
                         $data['image'] = (string)'storeimages/'.$result['file'];
                    }
                    //echo $data['image'];exit();
                    chmod($base_path,0777);
                } catch (\Exception $e) {
                     $this->messageManager->addError($e->getMessage());
                     $this->_redirect('*/*/edit', array('shopfinder_id' => $this->getRequest()->getParam('shopfinder_id'), '_current' => true));
                     return;
                }
            }
            else if($data['image'] == '' && $data['image_exists'] ==0){
                 $this->messageManager->addError(__('Image is required fields.'));
                 $this->_redirect('*/*/edit', array('shopfinder_id' => $this->getRequest()->getParam('shopfinder_id'), '_current' => true));
                 return;
            }
            $id = $this->getRequest()->getParam('shopfinder_id');
            if ($id) {
                $model->load($id);
            }
            $model->setData($data);

            // Generate a unique id and set it to the 'identifier' field
            $uniqueId = uniqid();
            $model->setIdentifier($uniqueId);

            try {
                $model->save();
                $this->messageManager->addSuccess(__('The Store has been saved.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['shopfinder_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the Store.'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['shopfinder_id' => $this->getRequest()->getParam('shopfinder_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
