<?php
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
  public function addAccount($first_name, $last_name, $email, $password)
  {
    $name = $first_name.' '.$last_name;
    try
    {
      /** check if input is valid */
      if (!$this->isNameValid($first_name, 3, 10))
      {
        $_SESSION['msg'] = "Name must be greater than 3 and less than 10";
        return (false);
      }
      if (!$this->isNameValid($last_name, 3, 10))
      {
        $_SESSION['msg'] = "Name must be greater than 3 and less than 10";
        return (false);
      }
      if (!$this->isEmailValid($email))
      {
        $_SESSION['msg'] = "Invalid Email";
        return (false);
      }
      if (!$this->isPasswordValid($password))
      {
        $_SESSION['msg'] = "Password must be greater than 7 characters";
        return (false);
      }

      /** check if user exist */
      $col = array('`user_id`');
      $where = array('`email`' => ':email');
      $value = array(':email' => $email);
      $exist = $this->db->dbGetData($col, "`users`", null, $where, $value);
      if (is_array($exist) && !empty($exist))
      {
        $_SESSION['msg'] = "Email already exist, please login";
        return (false);
      }
      
      /** user doesn't exist, insert into users table */
      $table = "`users`";
      $columns = array ("`first_name`", "`last_name`", "`email`", "`password`");
      $password = password_hash($password, PASSWORD_DEFAULT);
      $values = array (
        ':first_name' => $first_name,
        ':last_name' => $last_name,
        ':email' => $email,
        ':password' => $password
      );
      $register = $this->db->insertData($table, $columns, $values);
      if ($register > 0)
      {
        $_SESSION['msg'] = "Registration Successful. Please Login";
        return($register); 
      }
      else
      {
        $_SESSION['msg'] = "Oops! Registration failed due to technical reasons";
        return (false);
      }
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
      if (!$this->isEmailValid($email)) 
      {
        $_SESSION['msg'] = "Invalid Email";
        return (false);
      }

      $where = array('`email`' => ':email');
      $value = array(':email' => $email);
      $user = $this->db->dbGetData(null, '`users`', null, $where, $value);
      $user = $user[0];
      if (is_array($user) && !empty($user)){
        if (password_verify($password, $user['password'])){
          $this->uid = $user['user_id'];
          $this->uname = $user['first_name'].' '.$user['last_name'];
          $this->email = $user['email'];
          $this->login = true;

          echo "<script>alert('Login successful');</script>";
          return (true);
        }else
        {
          $_SESSION['msg'] = "Incorrect Password";
          return (false);
        }
      }
      else
      {
        $_SESSION['msg'] = "User does not exist";
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
  public function isNameValid(string $name, int $min = 4, int $max = 30) : bool
  {
    if (mb_strlen($name) > $min && mb_strlen($name) < $max)
    {
      if (!preg_match("/^[a-zA-Z- ']*$/", $name)){
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