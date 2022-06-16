<?php
 //require_once "../config.php";

/**
 * Account - a class that handles everything related to the user
 * Creates new account for users if they don't exist
 * Handles login and logout, amongst other things
 */

class Account
{
  private Database $db;
  private $uid = NULL;
  private $uname = NULL;
  private $email = NULL;
  private $login = FALSE;

  /**Create an instance of account with the current database connection object */
  public function __construct(Database $db){
    $this->db = $db;
  }
  /**get account user id */
  public function getUid()
  {
    return $this->uid;
  }
  /**get account user name */
  public function getUname()
  {
    return $this->uname;
  }
  /**get account email */
  public function getEmail()
  {
    return $this->email;
  }
  /**get login status */
  public function getLogin()
  {
    return $this->login;
  }
  /**
   * addAccount - adds a new user to the database if it doesn't exist
   * @first_name: first name of the user
   * @last_name: last name of the user
   * @email: email of the user
   * @password: password of the user
   * Return: the id of the new account, -1 if failed to create user
   */
  public function addAccount($first_name, $last_name, $email, $password): int
  {
    $name = $first_name.' '.$last_name;
    try
    {
      /** check if input is valid */
      if (!$this->isNameValid($name)) { throw new Exception("Invalid Name"); }
      if (!$this->isEmailValid($email)) { throw new Exception("Invalid Email"); }
      if (!$this->isPasswordValid($password)) { throw new Exception("Invalid Password"); }

      /** check if user exist */
      $col = array('`user_id`');
      $where = array('`email`' => ':email');
      $value = array(':email' => $email);
      $exist = $this->db->dbGetData($col, "`users`", null, $where, $value);
      if ($exist) { throw new Exception("User already exists"); }
      
      /** user doesn't exist, insert into users table */
      //insert method is yet to be implemented in database classiii9ki9
      //$hash = password_hash($password, PASSWORD_DEFAULT);
      // $values = array(
      //   ':first_name' => $first_name,
      //   ':last_name' => $last_name,
      //   ':email' => $email,
      //   ':password' => $hash
      // );
      // $register = dbInsertInto('users', $values);
      // return ($register);
      return 0;
    }
    catch(Exception $err)
    {
      return (-1);
    };
  }
  /**
   * login - authenticates user login
   * @email: email of user
   * @password password of user
   * Return: true on success, 1 if a user is logged in already, false on failure
   */
  public function login($email, $password) 
  {
    try{
      if ($this->uid != NULL && $this->login != false) { return (1); }
      if (!$this->isEmailValid($email)) { throw new Exception("Invalid Email"); }

      $where = array('`email`' => ':email');
      $value = array(':email' => $email);
      $user = $this->db->dbGetData(null, '`users`', null, $where, $value);
      echo ' <br>sp <br>';
      var_dump($user);
      if (is_array($user)){
        if (password_verify($password, $user['password'])){
          $this->uid = $user['user_id'];
          $this->uname = $user['first_name'].' '.$user['last_name'];
          $this->email = $user['email'];
          $this->login = true;

          echo "<script>alert('login successful');</script>";
          return (true);
        }else {echo "<script>alert('Wrong password. login not successful');</script>"; }
      }
      else{
        return (false);
      }
      
    }
    catch(Exception $err){
      //catch exception
    }
  }
  /**
   * isNameValid - check if name is valid
   * @name: name to check
   * Return: true or false
   */
  public function isNameValid($name) : bool
  {
    if (mb_strlen($name) < 30 && mb_strlen($name) > 4)
    {
      if (!preg_match("/^[a-zA-Z-']*$/", $name)){
        return false;
      }else{
        return true;
      }
    }; return false;
  }
  /**
   * isPasswordValid - check if password is valid
   * @password: password to check
   * Return: true or false
   */
  public function isPasswordValid($password) : bool
  {
    if (mb_strlen($password) > 7)
    {
      return true;
    }; return false;
  }
  /**
   * isEmailValid - check if email is valid
   * @email: email to check
   * Return: true or false
   */
  public function isEmailValid($email) : bool
  {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
      return false;
    }; return true;
  }

}
?>