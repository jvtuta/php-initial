<?php 

namespace Vendor\MFJvtuta\Model;

use Conn;

class Model extends Conn
{
  /**
   * @param string|null $db
   * @param string $table
   * @return void
   */
  public function __construct(?string $db = null, string $table)
  {
    if (!is_null($db)) {
      parent::__construct($db);
    } else {
      parent::__construct();
    }

    $this->table = $table;
  }

  public function get(array $params = [], bool $safe = true)
  {
    $result = parent::get($params);
    if (isset($result->{'count(*)'})) {
      return $result->{'count(*)'};
    }
    return $result;
  }
}

?>