<?php
namespace Whiteapp\ShopFinder\Block;
/**
 * @author Mustapha <bouarfamus@gmail.com>
 */
class ShopFinder extends \Magento\Framework\View\Element\Template
{
	/**
     * @var \Whiteapp\ShopFinder\Model\shopfinderFactory
     */
    protected $_shopfinderFactory;
    protected $_status;
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Whiteapp\ShopFinder\Model\ShopFinderFactory $shopfinderFactory,
        \Whiteapp\ShopFinder\Model\Status $status
    )
    {
        parent::__construct($context);
        $this->_shopfinderFactory = $shopfinderFactory;
        $this->_status = $status;
        $this->scopeConfig = $context->getScopeConfig();
    }


    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    public function getAllStores()
    {
        $collection = $this->_shopfinderFactory->create()->getCollection();
        return $collection;
    }
    public function getStoreConfigPerPageValue()
    {
        return $this->scopeConfig->getValue(
            'xj_settings/general/perPage',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    public function getGoogleApiKey()
    {
        return $this->scopeConfig->getValue(
            'xj_settings/general/apikey',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
