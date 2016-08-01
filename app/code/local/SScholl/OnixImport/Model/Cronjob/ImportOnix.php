<?php /**************** Copyright notice ************************
 *  (c) 2011 Simon Eric Scholl <simon@sdscholl.de>
 *  All rights reserved
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 ***************************************************************/

class SScholl_OnixImport_Model_Cronjob_ImportOnix
	extends SScholl_OnixImport_Model_Cronjob_Abstract
{

	protected $_coincidentProcesses = 5;

	public function _construct()
	{
		$this->setFolder($this->_config()->getImportPath());
		return parent::_construct();
	}

	/**
	 * cron:			sscholloniximport_convert_onix
	 * shedule-time:	* * * * *
	 */
	protected function _processFile($fileName)
	{
		$path = $this->_config()->getImportPath($fileName);
		$pathLocked = $this->_config()->getImportPath('.lock' . $fileName);
		$pathError = $this->_config()->getImportPath('.error' . $fileName);
		$pathDone = $this->_config()->getImportedPath($fileName);
		/* @var $onix sscholl_Onix_Model_File */
		$onix = Mage::getModel('sschollonix/file');
		$onix->init($fileName, $path, $pathLocked, $pathError, $pathDone);
		if ($onix->lock()) {
			if ( ($books = $onix->getBooks()) ) {
				/* @var $onix SScholl_OnixImport_Model_Import */
				$import = Mage::getModel('sscholloniximport/import');
				$import->import($books, $fileName);
				$onix->done();
			} else {
				$onix->error();
			}
		}
		return true;
	}

	protected function _initFile($file) {
		if (
			strstr($file, '.lock')
			|| strstr($file, '.error')
			|| !stristr($file, '.xml')
		) {
			return false;
		}
		return parent::_initFile($file);
	}

}
