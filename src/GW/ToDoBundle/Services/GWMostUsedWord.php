<?php
namespace GW\ToDoBundle\Services;

class GWMostUsedWord extends \Twig_Extension
{
  /**
   * Return le mot le plus utilisé dans un ToDo
   *
   * @param ToDo $todo
   * @return Array
   */
  public function mostUsed($todo)
  {
    $content = ucwords(strtolower($todo->getContent()));
    $contentArray = explode(' ', $content);
    $resultArray = array_count_values($contentArray);
    $getMaxValuesKeys = array_keys($resultArray, max($resultArray));
    $return = sort($getMaxValuesKeys);
    return $getMaxValuesKeys;
  }

  public function getFunctions()
  {
    return array(
      'getMostUsed' => new \Twig_Function_Method($this, 'mostUsed')
    );
  }

  public function getName()
  {
    return 'GWMostUsedWord';
  }

}
