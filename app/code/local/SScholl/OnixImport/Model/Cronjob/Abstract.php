<?php /**************** Copyright notice ************************
 *  (c) 2011 Simon Eric Scholl <simon@sdscholl.de>
 *  All rights reserved
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 ***************************************************************/

class SScholl_OnixImport_Model_Cronjob_Abstract
	extends SScholl_OnixImport_Model_Abstract
{

	/* stop cron afer 24 minutes */
	protected $_stopCronAfter = 1500;

	protected $_coincidentProcesses = 1;

	protected $_break = false;

	public function _construct()
	{
		$this->_cronEnd = time() + $this->_stopCronAfter;
		return parent::_construct();
	}

	public function run($test = false)
	{
		if ( $test === true ) {
			$this->setFolder($this->_config()->getConvertPath() . test);
		}
		foreach (scandir($this->getFolder()) as $file) {
			if ($this->_getBreak())					break;
			if ($file === '.' || $file === '..')	continue;
			if (!$this->_initFile($file))			continue;
			if (!$this->_processFile($file))		break;
		}
	}

	protected function _setBreak()
	{
		$this->_break = true;
	}

	protected function _getBreak()
	{
		if ($this->_break) return $this->_break;
		if ($this->getFolder()) {
			$files = 0;
			foreach (scandir($this->getFolder()) as $file) {
				if (strstr($file, '.lock')) ++ $files;
				if ($files >= $this->_coincidentProcesses) {
					$this->_break = true;
				}
			}
		}
		return $this->_break;
	}

	protected function _initFile($file)
	{
		return !is_dir($this->getFolder() . DS . $file);
	}

	abstract protected function _processFile($file);

	private $_cronEnd; //TODO add functionality

}