<?php

namespace GW\ToDoBundle\Tests\Services;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use GW\ToDoBundle\Entity\ToDo;

class DefaultControllerTest extends WebTestCase
{
  private $mostusedService;
  private $todo;

  public function setUp()
  {
    self::bootKernel();

    $this->mostusedService = static::$kernel->getContainer()
        ->get('gw_to_do.mostused');
    $this->todo = new ToDo;
  }

  public function testMostUsedWithOneResult()
  {
    $this->todo->setContent('Lorem Lorem Lorem Lorem Lorem Lorem Lorem ipsum ipsum ipsum ipsum leo leo leo leo leo leo leo leo leo leo leo leo leo leo leo leo leo leo leo leo leo');
    $result = $this->mostusedService->mostUsed($this->todo);
    $exceptedArray = ['Leo'];
    $excepted = asort($exceptedArray);

    $this->assertEquals($exceptedArray, $result);
  }
  public function testMostUsedWithOneResultCaseSensitive()
  {
    $this->todo->setContent('Lorem Lorem Lorem Lorem Lorem Lorem Lorem ipsum ipsum ipsum ipsum lEo lEo LEO leo leo lEo lEo LEO leo leo lEo lEo LEO leo leo lEo lEo LEO leo leo lEo lEo LEO leo leo lEo lEo LEO leo leo lEo lEo LEO leo leo lEo lEo LEO leo leo');
    $result = $this->mostusedService->mostUsed($this->todo);
    $exceptedArray = ['Leo'];
    $excepted = asort($exceptedArray);

    $this->assertEquals($exceptedArray, $result);
  }
  public function testMostUsedWithManyResult()
  {
    $this->todo->setContent('Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem ipsum ipsum ipsum ipsum leo leo leo leo leo leo leo leo leo leo leo leo leo leo leo leo leo leo leo leo leo');
    $result = $this->mostusedService->mostUsed($this->todo);
    $exceptedArray = ['Leo', 'Lorem'];
    $excepted = asort($exceptedArray);

    $this->assertEquals($exceptedArray, $result);
  }
  public function testNotMostUsedWithManyResult()
  {
    $this->todo->setContent('Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem ipsum ipsum ipsum ipsum leo leo leo leo leo leo leo leo leo leo leo leo leo leo leo leo leo leo leo leo leo');
    $result = $this->mostusedService->mostUsed($this->todo);
    $exceptedArray = ['Lea', 'Loraem'];
    $excepted = asort($exceptedArray);

    $this->assertNotEquals($exceptedArray, $result);
  }
}
