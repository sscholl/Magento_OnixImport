<?php /**************** Copyright notice ************************
 *  (c) 2011 Simon Eric Scholl <simon@sdscholl.de>
 *  All rights reserved
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 ***************************************************************/

class SScholl_OnixImport_Model_Import
	extends SScholl_OnixImport_Model_Abstract
{

	public function import($books, $fileName)
	{
		//commented out - sschollsolrcatalog module required
		//Mage::getResourceSingleton('sschollsolrcatalog/product')->setCollectionSave(true);

		foreach ( $books as $book ) {
			/* @var $productConvert SScholl_Books_Model_Product_Convert */
			$productConvert = Mage::getModel('sschollbooks/product_convert');
			$productConvert->setBook($book);
			$productConvert->import();
			$product = $productConvert->getProduct();
			$product->setFileName($fileName);
			if ( $product->getSku() ) {
				try {
					$product->save();
				} catch (Exception $e) {
					Mage::logException($e);
					break;
				}
			}
		}

		//commented out - sschollsolrcatalog module required
		//Mage::getResourceSingleton('sschollsolrcatalog/product')->saveCollection();
	}

}
