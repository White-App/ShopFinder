<?php
namespace Whiteapp\ShopFinder\Controller\Index;
/**
 * @author Mustapha <bouarfamus@gmail.com>
 */
class Search extends \Magento\Framework\App\Action\Action
{

    public function execute()
    {
		$center_lat = $this->getRequest()->getParam('lat');
        $center_lng = $this->getRequest()->getParam('lng');
        $radius = $this->getRequest()->getParam('radius');

		$this->_resources = \Magento\Framework\App\ObjectManager::getInstance()
		->get('Magento\Framework\App\ResourceConnection');
		$connection= $this->_resources->getConnection();

		$storeTable = $this->_resources->getTableName('shopfinder');
		$dom = new \DOMDocument("1.0");
		$node = $dom->createElement("markers");
		$parnode = $dom->appendChild($node);


		$query = sprintf("SELECT address, title , latitude , longitude , ( 3959 * acos( cos( radians('%s') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( latitude ) ) ) ) AS distance FROM ".$storeTable." where is_active = 1  HAVING distance < '%s' ORDER BY distance LIMIT 0 , 20 ",
		  ($center_lat),
		  ($center_lng),
		  ($center_lat),
		  ($radius));
		$result = $connection->fetchAll($query);
		if (!$result) {
		  die("Invalid query: " . mysql_error());
		}
		header("Content-type: text/xml");
		// Iterate through the rows, adding XML nodes for each
		foreach ($result as $row){
		  $node = $dom->createElement("marker");
		  $newnode = $parnode->appendChild($node);
		  $newnode->setAttribute("name", $row['title']);
		  $newnode->setAttribute("address", $row['address']);
		  $newnode->setAttribute("lat", $row['latitude']);
		  $newnode->setAttribute("lng", $row['longitude']);
		  $newnode->setAttribute("distance", $row['distance']);
		}
		echo $dom->saveXML();


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
