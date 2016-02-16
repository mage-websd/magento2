<?php
/**
 * Ebizmarts_MAgeMonkey Magento JS component
 *
 * @category    Ebizmarts
 * @package     Ebizmarts_MageMonkey
 * @author      Ebizmarts Team <info@ebizmarts.com>
 * @copyright   Ebizmarts (http://ebizmarts.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Ebizmarts\MageMonkey\Helper;

use Magento\Store\Model\Store;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_ACTIVE           = 'magemonkey/general/active';
    const XML_PATH_APIKEY           = 'magemonkey/general/apikey';
    const XML_PATH_MAXLISTAMOUNT    = 'magemonkey/general/maxlistamount';
    const XML_PATH_LIST             = 'magemonkey/general/list';
    const XML_PATH_LOG              = 'magemonkey/general/log';
    const XML_PATH_MAPPING          = 'magemonkey/general/mapping';
    const XML_PATH_CONFIRMATION_FLAG = 'newsletter/subscription/confirm';


    protected $_storeManager;
    protected $_mlogger;
    protected $_groupRepositoryInterface;
    protected $_scopeConfig;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Ebizmarts\MageMonkey\Model\Logger\Magemonkey $logger
     * @param \Magento\Customer\Api\GroupRepositoryInterface $groupRepositoryInterface
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Ebizmarts\MageMonkey\Model\Logger\Magemonkey $logger,
        \Magento\Customer\Api\GroupRepositoryInterface $groupRepositoryInterface,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    )
    {
        $this->_storeManager                = $storeManager;
        $this->_mlogger                     = $logger;
        $this->_groupRepositoryInterface    = $groupRepositoryInterface;
        $this->_scopeConfig                 = $scopeConfig;
        parent::__construct($context);
    }

    public function isMonkeyEnabled($store = null)
    {
        return $this->scopeConfig->getValue(self::XML_PATH_ACTIVE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store);
    }
    public function isDoubleOptInEnabled($store = null)
    {
        return $this->_scopeConfig->getValue(self::XML_PATH_CONFIRMATION_FLAG, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store);
    }
    public function getApiKey($store = null)
    {
        return $this->scopeConfig->getValue(self::XML_PATH_APIKEY, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store);
    }
    public function getDefaultList($store = null)
    {
        return $this->scopeConfig->getValue(self::XML_PATH_LIST, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store);
    }
    public function getLogger()
    {
        return $this->_logger;
    }
    public function log($message,$store=null)
    {
        if($this->scopeConfig->getValue(self::XML_PATH_LOG, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store))
        {
            $this->_mlogger->info($message);
        }
    }
    public function getMergeVars($customer,$store = null)
    {
        $this->log('getMergeVars');
        $merge_vars = array();
        $mergeVars  = unserialize($this->scopeConfig->getValue(self::XML_PATH_MAPPING, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store));
        foreach($mergeVars as $map)
        {
            $customAtt = $map['magento'];
            $chimpTag  = $map['mailchimp'];
            if($chimpTag && $customAtt){

                $key = strtoupper($chimpTag);
                switch ($customAtt) {
                    case 'gender':
                        $val = (int)$customer->getData(strtolower($customAtt));
                        if($val == 1){
                            $merge_vars[$key] = 'Male';
                        }elseif($val == 2){
                            $merge_vars[$key] = 'Female';
                        }
                        break;
                    case 'dob':
                        $dob = (string)$customer->getData(strtolower($customAtt));
                        if($dob){
                            $merge_vars[$key] = (substr($dob, 5, 2) . '/' . substr($dob, 8, 2));
                        }
                        break;
                    case 'billing_address':
                    case 'shipping_address':
                        $addr = explode('_', $customAtt);
                        $address = $customer->{'getPrimary'.ucfirst($addr[0]).'Address'}();
                        if($address){
                            $merge_vars[$key] = array(
                                'addr1'   => $address->getStreet(1),
                                'addr2'   => $address->getStreet(2),
                                'city'    => $address->getCity(),
                                'state'   => (!$address->getRegion() ? $address->getCity() : $address->getRegion()),
                                'zip'     => $address->getPostcode(),
                                'country' => $address->getCountryId()
                            );
                            $telephone = $address->getTelephone();
                            if($telephone){
                                $merge_vars['TELEPHONE'] = $telephone;
                            }
                            $company = $address->getCompany();
                            if($company){
                                $merge_vars['COMPANY'] = $company;
                            }
                        }
                        break;
                    case 'group_id':
//                        $group_id = (int)$customer->getData(strtolower($customAtt));
//                        $customerGroup = $this->_groupRepositoryInterface->getList('');
//                        $this->log(print_r($customerGroup));
////                        $customerGroup = Mage::helper('customer')->getGroups()->toOptionHash();
////                        if($group_id == 0){
////                            $merge_vars[$key] = 'NOT LOGGED IN';
////                        }else{
////                            $merge_vars[$key] = $customerGroup[$group_id];
////                        }
                        break;
                    default:
                        if( ($value = (string)$customer->getData(strtolower($customAtt))))
                        {
                            $merge_vars[$key] = (string)$customer->getData(strtolower($customAtt));
                        }
                        break;

                }
            }
        }
        return $merge_vars;
    }
    public function createWebhook()
    {

    }
}