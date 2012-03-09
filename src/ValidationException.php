<?php
/**
 * @package Wsdl2PhpGenerator
 */

require_once dirname(__FILE__).'/../lib/Wsdl2PhpException.php';

/**
 * Wrapper class for Wsdl2PhpException, only use is to collect functionality in one namespace
 * This groups all validation exeptions to one class
 *
 * @package Wsdl2PhpGenerator
 * @author Fredrik Wallgren <fredrik.wallgren@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @see Wsdl2PhpException
 * @see Validator
 */
class ValidationException extends Wsdl2PhpException
{

}

