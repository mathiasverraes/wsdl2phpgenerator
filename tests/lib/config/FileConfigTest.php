<?php
/**
 * @package configTest
 */

/**
 * Include the needed files
 */
require_once dirname(__FILE__).'/../../../lib/config/FileConfig.php';

/**
 * Test class for FileConfig.
 * Generated by PHPUnit on 2010-01-20 at 23:58:55.
 * @package configTest
 */
class FileConfigTest extends PHPUnit_Framework_TestCase
{
  /**
   * @var FileConfig
   */
  protected $object;

  private $fileName;

  /**
   * Sets up the fixture, for example, opens a network connection.
   * This method is called before a test is executed.
   */
  protected function setUp()
  {
    // Add the file fixture
    $this->fileName = '/tmp/'.md5(time().mt_rand(0, 1000));
    $contents = '#Comment'.PHP_EOL.'foo=bar';
    file_put_contents($this->fileName, $contents);

    $this->object = new FileConfig($this->fileName);
  }

  /**
   * Tears down the fixture, for example, closes a network connection.
   * This method is called after a test is executed.
   */
  protected function tearDown()
  {
    // Remove the file
    unlink($this->fileName);
    $this->object = null;
  }

  /**
   * Test the set function standard
   */
  public function testSet()
  {
    $this->object->set('bar', 'foo');
    $this->assertEquals('bar', $this->object->get('foo'));
    $this->assertEquals('foo', $this->object->get('bar'));
  }

  /**
   * Test the set function with buffer
   */
  public function testSetBuffer()
  {
    $this->object = new FileConfig($this->fileName, true);
    $this->object->set('bar', 'foo');
    $this->assertEquals('bar', $this->object->get('foo'));
    $this->assertEquals('foo', $this->object->get('bar'));
  }

  /**
   * Test the get function with invalid file
   */
  public function testInvalidFile()
  {
    $this->object = new FileConfig($this->fileName, true, '$');
    $this->setExpectedException('Wsdl2PhpException');
    $this->object->get('woho');
  }

  /**
   * Test the get function with no file
   */
  public function testNoFile()
  {
    $this->object = new FileConfig('');
    $this->setExpectedException('Wsdl2PhpException');
    $this->object->get('woho');
  }

  /**
   *
   */
  public function testGet()
  {
    $this->assertEquals('bar', $this->object->get('foo'));
    $this->setExpectedException('Wsdl2PhpException');
    $this->object->get('woho');
  }

  /**
   *
   */
  public function testExists()
  {
    $this->assertTrue($this->object->exists('foo'));
    $this->assertFalse($this->object->exists('woho'));
  }
}
?>

