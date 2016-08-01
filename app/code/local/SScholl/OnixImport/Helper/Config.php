<?php /**************** Copyright notice ************************
 *  (c) 2011 Simon Eric Scholl <simon@sdscholl.de>
 *  All rights reserved
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 ***************************************************************/

class SScholl_OnixImport_Helper_Config
{

	public function getImportPath($file = '')
	{
		return Mage::getBaseDir() . DS . $this->_getImportFolder($file);
	}

	public function getImportedPath($file = '')
	{
		return Mage::getBaseDir() . DS . $this->_getImportedFolder($file);
	}

	private function _getImportFolder($file = '')
	{
		if ( $file ) $file = DS . $file;
		return Mage::getStoreConfig('sscholloniximport/folder/import') . $file;
	}

	private function _getImportedFolder($file = '')
	{
		if ( $file ) $file = DS . $file;
		return  Mage::getStoreConfig('sscholloniximport/folder/imported') . $file;
	}

}