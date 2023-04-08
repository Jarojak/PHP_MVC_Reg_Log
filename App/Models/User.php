<?php

namespace App\Models;

use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class User extends \Core\Model
{

  /**
   * Values returned from $_POST
   * 
   * @var array
   */
  private $keys = [];

  /**
   * Class constructor
   *
   * @param array $data  Initial property values
   *
   * @return void
   */
  public function __construct($data)
  {
    foreach ($data as $key => $value) {
      $this->keys[$key] = $value;
    };
  }

  /**
   * Save the user model with the current property values
   *
   * @return void
   */
  public function save()
  {
    $password_hash = password_hash($this->keys['password'], PASSWORD_DEFAULT);

    $sql = 'INSERT INTO users (name, email, password_hash)
            VALUES (:name, :email, :password_hash)';

    $db = static::getDB();
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':name', $this->keys['name'], PDO::PARAM_STR);
    $stmt->bindValue(':email', $this->keys['email'], PDO::PARAM_STR);
    $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);

    $stmt->execute();
  }
}
