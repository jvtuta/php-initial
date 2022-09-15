<?php

namespace vendor\MFJvtuta\Database;

use PDO;

class Conn extends SqlQuery
{
  private PDO $pdo;
  protected string $table;

  public function __construct($db = 'cdr_suite')
  {
    $this->pdo = new PDO(DSN . ';dbname=' . $db, USER, PASS);
  }
  /**
   * Change database 
   * @param string $db
   * @return void
   */
  protected function setDb($db): void
  {
    $this->pdo->exec('USE ' . $db);
  }
  /**
   * Change table 
   * @param string $table
   * @return void
   */
  protected function setTable($table): void
  {
    $this->table = $table;
  }
  /**
   * Fix wheres in the clause of query
   * @return void
   */
  private function verifyWhere()
  {
    if (strpos($this->query, 'WHERE')) {
      $query = explode('WHERE', $this->query);
      $i = 0;
      while ($i < count($query) - 1) {
        $i == 0 ? $query[$i] .= ' WHERE' : $query[$i] .= ' AND';
        $i++;
      }
      $this->query = join(' ', $query);
    }
  }
}

?>