<?php

include_once('PhpElement.php');
include_once('PhpDocComment.php');
include_once('PhpFunction.php');

/**
 * Class that represents the source code for a class in php
 *
 * @package phpSource
 * @author Fredrik Wallgren <fredrik@wallgren.me>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class PhpClass extends PhpElement
{
  /**
   *
   * @var array An array of strings, contains all the filenames to include for the class
   * @access private
   */
  private $dependencies;
  
  /**
   *
   * @var bool If the class should be protected by a if(!class_exists() statement
   * @access private
   */
  private $classExists;

  /**
   *
   * @var bool If the class is final
   * @access private
   */
  private $final;

  /**
   *
   * @var string
   * @access private
   */
  private $extends;

  /**
   *
   * @var array Array of PhpVariable objects
   * @access private
   */
  private $variables;

  /**
   *
   * @var array Array of PhpFunction objects
   * @access private
   */
  private $functions;

  /**
   *
   * @var PhpDocComment A description of the class in phpdoc format
   * @access private
   */
  private $comment;

  /**
   *
   * @param string $identifier
   * @param bool $classExists
   * @param string $extends A string of the class that this class extends
   * @param PhpDocComment $comment
   * @param bool $final
   */
  public function __construct($identifier, $classExists = false, $extends = '', PhpDocComment $comment = null, $final = false)
  {
    $this->dependencies = array();
    $this->classExists = $classExists;
    $this->comment = $comment;
    $this->final = $final;
    $this->identifier = $identifier;
    $this->access = '';
    $this->extends = $extends;
    $this->variables = array();
    $this->functions = array();
  }

  /**
   *
   * @return string Returns the compete source code for the class
   */
  public function getSource()
  {
    $ret = '';

    if ($this->classExists)
    {
      $ret .= 'if (!class_exists("'.$this->identifier.'")) '.PHP_EOL.'{'.PHP_EOL;
    }

    if (count($this->dependencies) > 0)
    {
      foreach ($this->dependencies as $file)
      {
        $ret .= 'include_once(\''.$file.'\');'.PHP_EOL;
      }
      $ret .= PHP_EOL;
    }

    if ($this->comment !== null)
    {
      $ret .= $this->comment->getSource();
    }

    if ($this->final)
    {
      $ret .= 'final ';
    }

    $ret .= 'class '.$this->identifier;

    if (strlen($this->extends) > 0)
    {
      $ret .= ' extends '.$this->extends;
    }

    $ret .= PHP_EOL.'{'.PHP_EOL;

    if (count($this->variables) > 0)
    {
      foreach ($this->variables as $variable)
      {
        $ret .= $variable->getSource();
      }
    }

    if (count($this->functions) > 0)
    {
      foreach ($this->functions as $function)
      {
        $ret .= $function->getSource();
      }
    }

    $ret .= PHP_EOL.'}'.PHP_EOL;

    if ($this->classExists)
    {
      $ret .= PHP_EOL.'}'.PHP_EOL;
    }

    return $ret;
  }

  /**
   * Adds a dependency to be loaded for the class to use
   * Only adds it if it does not already exist
   *
   * @param string $filename
   */
  public function addDependency($filename)
  {
    if (in_array($filename, $this->dependencies) == false)
    {
      $this->dependencies[] = $filename;
    }
  }

  /**
   * Adds a variable to the class
   * Throws Exception if the variable does already exist
   *
   * @param PhpVariable $variable The variable object to add
   * @access public
   */
  public function addVariable(PhpVariable $variable)
  {
    if ($this->variableExists($variable->getIdentifier()))
    {
      throw new Exception('A variable of the name ('.$variable->getIdentifier().') does already exist.');
    }

    $this->variables[$variable->getIdentifier()] = $variable;
  }

  /**
   * Adds a function to the class
   * Overwrites
   *
   * @param PhpFunction $function The function object to add
   * @access public
   */
  public function addFunction(PhpFunction $function)
  {
    if ($this->functionExists($function->getIdentifier()))
    {
      throw new Exception('A function of the name ('.$function->getIdentifier().') does already exist.');
    }

    $this->functions[$function->getIdentifier()] = $function;
  }
  
  /**
   * Checks if a variable with the same name does already exist
   *
   * @access public
   * @param string $identifier
   * @return bool
   */
  public function variableExists($identifier)
  {
    return array_key_exists($identifier, $this->variables);
  }

  /**
   * Checks if a function with the same name does already exist
   *
   * @access public
   * @param string $identifier
   * @return bool
   */
  public function functionExists($identifier)
  {
    return array_key_exists($identifier, $this->functions);
  }
}