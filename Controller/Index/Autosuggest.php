<?php
namespace Whiteapp\ShopFinder\Controller\Index;
/**
 * @author Mustapha <bouarfamus@gmail.com>
 */
class Autosuggest extends \Magento\Framework\App\Action\Action
{
    public function execute()
    {
        $searchText = $this->getRequest()->getParam('searchValue');
        $this->_resources = \Magento\Framework\App\ObjectManager::getInstance()
        ->get('Magento\Framework\App\ResourceConnection');
        $connection= $this->_resources->getConnection();

        $storeTable = $this->_resources->getTableName('shopfinder');
        //$query = "SELECT shopfinder_id,title FROM $storeTable WHERE title LIKE '".$searchText.'%'."'";
        $query = "SELECT shopfinder_id,title FROM $storeTable WHERE title LIKE '%".$searchText."%' ";
        $result = $connection->fetchAll($query);
        $array = array();
        $html = '<div class="tt-suggestion">';
        if($result)
        {
            foreach ($result as $value) {
                $html .= '<p style="white-space: normal;" onClick="selectOption(this);jQuery(\'#searchlocations\').on(\'click\', function(){ searchLocations('.$value['shopfinder_id'].'); });">'.$value['title'].'</p>';
            }
        }
        else
        {
            $html .= '<p style="white-space: normal;">No Records Found..!</p>';
        }
        echo $html .= '</div>';
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
