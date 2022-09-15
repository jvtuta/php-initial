<?php 

namespace Vendor\MFJvtuta\Database;

use Exception;

abstract class SqlQuery
{
  protected string $query;
  /**
   * Get query string 
   * @return string 
   */
  public function getQuery()
  {
    if (empty($this->query))
      throw new Exception("Empty query, error processing", 1);

    return $this->query;
  }
  /**
   * Peform a select clause in the query
   * @param array $params fields
   * @return $this
   */
  protected function select(array $params = [])
  {
    if (empty($params)) {
      $this->query = 'SELECT * FROM ' . $this->table;
    } else {
      $this->query = 'SELECT ' . implode(', ', $params) . ' FROM ' . $this->table;
    }
    return $this;
  }
  /**
   * Peform a whre clause in the query
   * @param array|string $params
   * @return $this
   */
  protected function where($params)
  {
    if (is_array($params)) {
      count($params) == 2
        ? $this->query .= " WHERE {$params[0]} = {$params[1]}"
        : $this->query .= " WHERE {$params[0]} {$params[1]} '{$params[2]}'";
    } else {
      $this->query .= ' WHERE ' . $params;
    }

    return $this;
  }
  /**
   * Peform a where in clause in the query
   * @param string $column
   * @param array $params
   * @return $this
   */
  protected function whereIn(string $column, array $params)
  {
    $this->query .= " WHERE {$column} IN (" . implode(', ', $params) . ")";
    return $this;
  }
  /**
   * Inject sql in the query string
   * @param string $sql
   * @return $this
   */
  protected function sql(string $query)
  {
    $this->query .= $query;
    return $this;
  }
  /**
   * Peform a count clause in the query
   * @param string|null $sql 
   * @return $this
   */
  protected function count(string $sql = null)
  {
    if (!is_null($sql))
      $this->query = 'select count(*) from (' . $sql . ') as count';
    else
      $this->query = 'select count(*) from ' . $this->table;

    return $this;
  }

  protected function between(string $column, array $params)
  {
    $this->query .= " WHERE {$column} BETWEEN '{$params[0]}' AND '{$params[1]}'";
    return $this;
  }

  protected function like(array $param)
  {

    $this->query .= " WHERE {$param[0]} LIKE '%{$param[1]}%'";
    return $this;
  }

  protected function whereOr(array $columns, array $params, bool $like = false)
  {
    if ($like) {
      $this->query .= " WHERE {$columns[0]} LIKE '%{$params[0]}%' OR {$columns[1]} LIKE '%{$params[1]}%'";
    } else {
      $this->query .= " WHERE {$columns[0]} = {$params[0]} OR {$columns[1]} = {$params[1]}";
    }
    return $this;
  }
} 

?>