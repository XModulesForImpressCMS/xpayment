<?php
/**
 * Invoice Transaction Gateway with Modular Plugin set
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Chronolabs Co-Op http://www.chronolabs.coop/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         xpayment
 * @since           1.30.0
 * @author          Simon Roberts <simon@chronolabs.coop>
 * @translation     Erol Konik <aphex@aphexthemes.com>
 * @translation     Mariane <mariane_antoun@hotmail.com>
 * @translation     Voltan <voltan@icms.ir>
 * @translation     Ezsky <ezskyyoung@gmail.com>
 * @translation     Richardo Costa <lusopoemas@gmail.com>
 * @translation     Kris_fr <kris@fricms.org>
 */



if (!defined('ICMS_ROOT_PATH')) {
	exit();
}
/**
 * Class for Blue Room Xcenter
 * @author Simon Roberts <simon@icms.org>
 * @copyright copyright (c) 2009-2003 ICMS.org
 * @package kernel
 */
class XpaymentAutotax extends icms_core_Object
{
	
    function __construct()
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
		$this->initVar('country', XOBJ_DTYPE_TXTBOX, null, false, 128);
		$this->initVar('code', XOBJ_DTYPE_TXTBOX, null, false, 3);
		$this->initVar('rate', XOBJ_DTYPE_DECIMAL, 0, false);	

		foreach($this->vars as $key => $data) {
			$this->vars[$key]['persistent'] = true;
		}
		
	}
	
	public function getValues($keys = null, $format = 's', $maxDepth = 1) {
		$ret = parent::getValues();
		$ret['form']['id'] = new icms_form_elements_Hidden('id['.$this->getVar('id').']', $this->getVar('id'));
		$ret['form']['country'] = new icms_form_elements_Text('', $this->getVar('id').'[country]', 45, 128, $this->getVar('country'));
		$ret['form']['code'] = new icms_form_elements_Text('', $this->getVar('id').'[code]', 5, 3, $this->getVar('code'));
		$ret['form']['rate'] = new icms_form_elements_Text('', $this->getVar('id').'[rate]', 15, 30, $this->getVar('rate'));
		$ret['form']['id'] = $ret['form']['id']->render();
		$ret['form']['country'] = $ret['form']['country']->render();
		$ret['form']['code'] = $ret['form']['code']->render();
		$ret['form']['rate'] = $ret['form']['rate']->render();
		return $ret;
	}
}


/**
* ICMS policies handler class.
* This class is responsible for providing data access mechanisms to the data source
* of ICMS user class objects.
*
* @author  Simon Roberts <simon@chronolabs.coop>
* @package kernel
*/
class XpaymentAutotaxHandler extends icms_ipf_Handler
{
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, 'autotax', "id", "country", '', 'xpayment');
    }
    
    function getTaxRate($code) {
    	$criteria = new icms_db_criteria_Item('code', $code);
    	$objects = $this->getObjects($criteria, false);
    	if (is_object($objects[0]))
    		return $objects[0]->getVar('rate');
    	else
    		return 0;
    }
}

?>