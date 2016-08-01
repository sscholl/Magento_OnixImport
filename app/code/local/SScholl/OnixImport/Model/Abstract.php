<?php /**************** Copyright notice ************************
 *  (c) 2011 Simon Eric Scholl <simon@sdscholl.de>
 *  All rights reserved
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 ***************************************************************/

class SScholl_OnixImport_Model_Abstract
	extends Varien_Object
{

	/**
	 * @var SScholl_OnixImport_Helper_Data
	 */
	protected $_helper = null;

	/**
	 * @var SScholl_OnixImport_Helper_Config
	 */
	protected $_configHelper = null;

	/**
	 * @return SScholl_OnixImport_Helper_Data
	 */
	protected function _helper()
	{
		if (is_null($this->_helper))
			$this->_helper = Mage::helper('sscholloniximport');
		return $this->_helper;
	}

	/**
	 * @return SScholl_OnixImport_Helper_Config
	 */
	protected function _config()
	{
		if (is_null($this->_configHelper))
			$this->_configHelper = Mage::helper('sscholloniximport/config');
		return $this->_configHelper;
	}

}