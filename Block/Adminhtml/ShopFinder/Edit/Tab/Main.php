<?php

namespace Whiteapp\ShopFinder\Block\Adminhtml\ShopFinder\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Cms\Model\Wysiwyg\Config;
use Magento\Directory\Model\Config\Source\Country;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;
use Magento\Store\Model\System\Store;
use Whiteapp\ShopFinder\Model\Status;


/**
 * ShopFinder edit form main tab
 */
/**
 * @author Mustapha <bouarfamus@gmail.com>
 */
class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var Store
     */
    protected $_systemStore;

    /**
     * @var Config
     */
    protected $_wysiwygConfig;

    /**
     * @var Status
     */
    protected $_status;
    /**
     * @var Country
     */
    protected $_country;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param Store $systemStore
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Store $systemStore,
        Config $wysiwygConfig,
        Status $status,
        Country $country,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_status = $status;
        $this->_country = $country;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm()
    {
        /* @var $model \Whiteapp\ShopFinder\Model\BlogPosts */
        $model = $this->_coreRegistry->registry('shopfinder');

        $isElementDisabled = false;

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Store Information')]);

        if ($model->getId()) {
            $fieldset->addField('shopfinder_id', 'hidden', ['name' => 'shopfinder_id']);
        }

        if($model->getIdentifier())
        {
            $fieldset->addField(
                'identifier',
                'text',
                [
                    'name' => 'identifier',
                    'label' => __('Identifier'),
                    'title' => __('Identifier'),
                    'required' => false,
                    'disabled' => true,
                    'readonly' => true
                ]
            );
        }

        $fieldset->addField(
            'title',
            'text',
            [
                'name' => 'title',
                'label' => __('Title'),
                'title' => __('Title'),
                'required' => true,
                'disabled' => $isElementDisabled
            ]
        );

        $dateFormat = $this->_localeDate->getDateFormat(
            \IntlDateFormatter::SHORT
        );

        $fieldset->addField(
            'address',
            'textarea',
            [
                'name' => 'address',
                'label' => __('Address'),
                'title' => __('Address'),
                'required' => true,
                'disabled' => $isElementDisabled
            ]
        );

        // Get a list of countries
        $countryList = $this->_country->toOptionArray();

        // Add the 'country' field
        $fieldset->addField(
            'country',
            'select',
            [
                'name' => 'country',
                'label' => __('Country'),
                'title' => __('Country'),
                'required' => true,
                'values' => $countryList,
            ]
        );

        $fieldset->addField(
            'latitude',
            'text',
            [
                'name' => 'latitude',
                'label' => __('Latitude'),
                'title' => __('Latitude'),
                'required' => true,
                'disabled' => $isElementDisabled
            ]
        );

        $fieldset->addField(
            'longitude',
            'text',
            [
                'name' => 'longitude',
                'label' => __('Longitude'),
                'title' => __('Longitude'),
                'required' => true,
                'disabled' => $isElementDisabled
            ]
        );

        $fieldset->addField('image_exists', 'hidden', [
                'name'               => 'image_exists',
                'value'              => 11
            ]
        );
        if($model->getImage())
        {
            $fieldset->addField(
                'image',
                'image',
                array(
                    'name' => 'image',
                    'label' => __('Store Image'),
                    'title' => __('Store Image'),
                    'required' => true,
                    'after_element_html' => "<script>require(['jquery', 'jquery/ui'], function($){
                          $( document ).ready(function() {
                              $('#page_image').change(function(){
                                 $('#page_image_exists').val(1);
                              });
                          });
                      });</script>",)
            );
        }
        else
        {
            $fieldset->addField(
                'image',
                'file',
                array(
                    'name' => 'image',
                    'label' => __('Store Image'),
                    'title' => __('Store Image'),
                    'required' => true,
                    'after_element_html' => "<script>require(['jquery', 'jquery/ui'], function($){
                          $( document ).ready(function() {
                              $('#page_image').change(function(){
                                 $('#page_image_exists').val(1);
                              });
                          });
                      });</script>",)
            );
        }

        $fieldset->addField(
            'is_active',
            'select',
            [
                'label' => __('Status'),
                'title' => __('Status'),
                'name' => 'is_active',
                'required' => true,
                'options' => $this->_status->getOptionArray(),
                'disabled' => $isElementDisabled
            ]
        );
        if (!$model->getId()) {
            $model->setData('is_active', $isElementDisabled ? '0' : '1');
        }

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Store Information');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Store Information');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
