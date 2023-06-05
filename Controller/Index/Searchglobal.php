<?php
namespace Whiteapp\ShopFinder\Controller\Index;
/**
 * @author Mustapha <bouarfamus@gmail.com>
 */
class Searchglobal extends \Magento\Framework\App\Action\Action
{
    public function execute()
    {
    	$center_lat = $this->getRequest()->getParam('lat');
        $center_lng = $this->getRequest()->getParam('lng');
        $radius = $this->getRequest()->getParam('radius');

        echo "<iframe src ='https://maps.google.com/maps?q=".$center_lat.",".$center_lng."&hl=".$radius.";z=10&amp;output=embed' width='975' height='330'></iframe>";
    }
    public function getAllStores()
    {
//     	 $object_manager = $this->getObjectManager();
		$object         = $this->_objectManager->create('Whiteapp\ShopFinder\Model\ShopFinderFactory');
        $collection = $object->create()->getCollection();
        $collection->addFieldToFilter('is_active' , '1');
        return $collection;
    }
    function parseToXML($htmlStr)
	{
		$xmlStr=str_replace('<','&lt;',$htmlStr);
		$xmlStr=str_replace('>','&gt;',$xmlStr);
		$xmlStr=str_replace('"','&quot;',$xmlStr);
		$xmlStr=str_replace("'",'&#39;',$xmlStr);
		$xmlStr=str_replace("&",'&amp;',$xmlStr);
		return $xmlStr;
	}

}
