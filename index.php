<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'GET') 
{
  $messages = array();
  if (!empty($_COOKIE['save'])) 
  {
    setcookie('save', '', 100000);
    setcookie('login', '', 100000);
    setcookie('pass', '', 100000);
    $messages[] = 'Спасибо, результаты сохранены.';
    if (!empty($_COOKIE['pass'])) 
    {
      $messages[] = sprintf('Вы можете <a href="login.php">войти</a> с логином <strong>%s</strong>
        и паролем <strong>%s</strong> для изменения данных.',
        strip_tags($_COOKIE['login']),
        strip_tags($_COOKIE['pass']));
    }
  }

  $errors = array();
  $errors['fio'] = !empty($_COOKIE['fio_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['date'] = !empty($_COOKIE['date_error']);
  $errors['gender'] = !empty($_COOKIE['gender_error']);
  $errors['arms'] = !empty($_COOKIE['arms_error']);
  $errors['arg'] = !empty($_COOKIE['arg_error']);
  $errors['about'] = !empty($_COOKIE['about_error']);
  $errors['check'] = !empty($_COOKIE['check_error']);

  if ($errors['fio']) 
  {
    setcookie('fio_error', '', 100000);
    $messages[] = '<div class="error">Заполните имя. Имя может содержать только русские / латинские символы, пробел, цифры и знак _</div>';
  }
  if ($errors['email'])
   {
    setcookie('email_error', '', 100000);
    $messages[] = '<div class="error">Заполните Email. Email может содержать только латинские символы, цифры, @ и знак . _ </div>';
  }
  if ($errors['date']) 
  {
    setcookie('date_error', '', 100000);
    $messages[] = '<div class="error">Заполните дату. Год-месяц-день</div>';
  }
  if ($errors['gender']) 
  {
    setcookie('gender_error', '', 100000);
    $messages[] = '<div class="error">Выберите пол.</div>';
  }
  if ($errors['arms'])
   {
    setcookie('arms_error', '', 100000);
    $messages[] = '<div class="error">Выберите количество конечностей.</div>';
  }
  if ($errors['arg'])
   {
    setcookie('arg_error', '', 100000);
    $messages[] = '<div class="error">Выберите свехрспособность.</div>';
  }
  if ($errors['about']) 
  {
    setcookie('about_error', '', 100000);
    $messages[] = '<div class="error">Заполните биографию (расскажите немного о себе).</div>';
  }
  if ($errors['check']) 
  {
    setcookie('check_error', '', 100000);
    $messages[] = '<div class="error">Подтвердите, что вы ознакомлены с контрактом.</div>';
  }
  $values = array();
  $values['fio'] = empty($_COOKIE['fio_value']) ? '' : strip_tags($_COOKIE['fio_value']);
  $values['email'] = empty($_COOKIE['email_value']) ? '' :  strip_tags($_COOKIE['email_value']);
  $values['date'] = empty($_COOKIE['date_value']) ? '' : strip_tags($_COOKIE['date_value']);
  $values['gender'] = empty($_COOKIE['gender_value']) ? '' : strip_tags($_COOKIE['gender_value']);
  $values['arms'] = empty($_COOKIE['arms_value']) ? '' : strip_tags($_COOKIE['arms_value']);
  $values['arg'] = empty($_COOKIE['arg_value']) ? '' : strip_tags($_COOKIE['arg_value']);
  $values['about'] = empty($_COOKIE['about_value']) ? '' : strip_tags($_COOKIE['about_value']);
  $values['check'] = empty($_COOKIE['check_value']) ? '' : strip_tags($_COOKIE['check_value']);
  if (empty($errors) && !empty($_COOKIE[session_name()]) &&
      session_start() && !empty($_SESSION['login'])) 
      {
    try 
    {
      $l = $_SESSION['login'];
      $stmt = $db->prepare("SELECT * FROM heroes2 WHERE login = ?");
      $stmt -> execute([$l]);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $values['fio'] = $row['fio'];
      $values['email'] = $row['email'];
      $values['date'] = $row['date'];
      $values['gender'] = $row['gender'];
      $values['arms'] = $row['arms'];
      $values['about'] = $row['about'];
      $values['check'] = $row['check'];
      $new = $db->prepare("SELECT abilility FROM abilites2 WHERE login = ?");
      $new -> execute([$_SESSION['login']]); 
      $row = $new->fetch(PDO::FETCH_ASSOC);
      $values['arg'] = $row['arg'];
    }
    catch(PDOException $e)
    {
      print('Error : ' . $e->getMessage());
      exit();
    }
    printf('Вход с логином %s, uid %d', $_SESSION['login'], $_SESSION['uid']);
  }
  include('form.php');
}
else 
{
  $errors = FALSE;
  if (empty($_POST['fio'])) 
  {
    setcookie('fio_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else 
  {
    setcookie('fio_value', $_POST['fio'], time() + 30 * 24 * 60 * 60);
  }
  if (empty($_POST['email']) || !preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $_POST['email'])) {
    setcookie('email_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else 
  {
    setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
  }
  if (empty($_POST['date']) || preg_match('/^[0-9]{2}-[0-9]{2}-[0-9]{4}$/', $_POST['date'])) 
  {
    setcookie('date_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else 
  {
    setcookie('date_value', $_POST['date'], time() + 30 * 24 * 60 * 60);
  }
  if (empty($_POST['gender'])) 
  {
    setcookie('gender_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else 
  {
    setcookie('gender_value', $_POST['gender'], time() + 30 * 24 * 60 * 60);
  }
  if (empty($_POST['arms'])) 
  {
    setcookie('arms_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else
  {
    setcookie('arms_value', $_POST['arms'], time() + 30 * 24 * 60 * 60);
  }
  if (empty($_POST['arg'])) 
  {
    setcookie('arg_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else
  {
    setcookie('arg_value', implode(',',$_POST['arg']), time() + 30 * 24 * 60 * 60);
  }  
  if (empty($_POST['about'])) {
    setcookie('about_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else 
  {
    setcookie('about_value', $_POST['about'], time() + 30 * 24 * 60 * 60);
  }  
  if (empty($_POST['check'])) 
  {
    setcookie('check_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else 
  {
    setcookie('check_value', $_POST['check'], time() + 30 * 24 * 60 * 60);
  }
  if ($errors) 
  {
    header('Location: index.php');
    exit();
  }
  else 
  {
    setcookie('fio_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('date_error', '', 100000);
    setcookie('gender_error', '', 100000);
    setcookie('arms_error', '', 100000);
    setcookie('arg_error', '', 100000);
    setcookie('about_error', '', 100000);
    setcookie('check_error', '', 100000);
  }
  $user = 'u47584';
  $pass = '3864156';
  $db = new PDO('mysql:host=localhost;dbname=u47584', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
  $fio = $_POST['fio'];
  $email = $_POST['email'];
  $date = $_POST['date'];
  $gender = $_POST['gender'];
  $arms = $_POST['arms'];
  $about = $_POST['about'];
  $dblogin = $_SESSION['login'];
  $arg = implode(',',$_POST['arg']);
  if (!empty($_COOKIE[session_name()]) &&
      session_start() && !empty($_SESSION['login'])) 
      {
    try 
    {
  
      $stmt = $db->prepare("UPDATE heroes2 SET fio = ?, email = ?, date = ?, gender = ?, arms = ?, about = ? WHERE login = ?");
      $stmt -> execute([$fio,$email,$date,$gender,$arms,$about,$dblogin]);
  
      $new = $db->prepare("UPDATE abilities2 SET ability = ? WHERE login = ?");
      $new -> execute([$arg, $dblogin]); 
    }
    catch(PDOException $e)
    {
      print('Error : ' . $e->getMessage());
      exit();
    }
  }
  else 
  {
    $login = uniqid();
    $tpass = uniqid();
    $pass = md5($tpass);
    setcookie('login', $login);
    setcookie('pass', $tpass);
    try 
    {
      $stmt = $db->prepare("INSERT INTO heroes2 SET fio = ?, email = ?, date = ?, gender = ?, arms = ?, about = ?, login = ?, password = ?");
      $stmt -> execute([$fio,$email,$date,$gender,$arms,$about,$login, $pass]);
  
      $new = $db->prepare("INSERT INTO abilities2 SET ability = ?, login = ?");
      $new -> execute([$arg, $login]); 
    }
    catch(PDOException $e)
    {
      print('Error : ' . $e->getMessage());
      exit();
    }
  }
  setcookie('save', '1');
  header('Location: ./');
}