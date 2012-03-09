<?php
/**
 * @package cliTest
 */

/**
 * Include the needed files
 */


require_once dirname(__FILE__).'/../../../lib/cli/CliParser.php';

/**
 * Test class for CliParser.
 * @package cliTest
 * Generated by PHPUnit on 2009-10-24 at 17:53:15.
 */
class CliParserTest extends PHPUnit_Framework_TestCase
{
  /**
   * @var CliParser
   */
  protected $object;

  /**
   * Sets up the fixture, for example, opens a network connection.
   * This method is called before a test is executed.
   */
  protected function setUp()
  {
    $this->object = new CliParser;
  }

  /**
   * Tears down the fixture, for example, closes a network connection.
   * This method is called after a test is executed.
   */
  protected function tearDown()
  {
  }

  /**
   *
   */
  public function testParse()
  {
    $arr = array('-a', '-b=foo', '-c', 'bar', '--export', '--foo=bar', '-xyz', '-=asd', 'bluff', 'inva--lid', '--test', 'value', '-q', 'woho');
    $this->object->parse($arr);

    $this->assertTrue($this->object->getValue('-a'));
    $this->assertEquals('foo', $this->object->getValue('-b'));
    $this->assertEquals('bar', $this->object->getValue('-c'));
    $this->assertTrue($this->object->getValue('--export'));
    $this->assertEquals('bar', $this->object->getValue('--foo'));
    $this->assertTrue($this->object->getValue('-x'));
    $this->assertTrue($this->object->getValue('-y'));
    $this->assertTrue($this->object->getValue('-z'));
  }
}

