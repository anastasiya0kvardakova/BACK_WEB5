<?php
header('Content-Type: text/html; charset=UTF-8');

session_start();

if (!empty($_SESSION['login'])) 
{
  header('Location: ./');
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') 
{
  if (!empty($_GET['error']))
  print("<div>Такого пользователя не существует!</div>");
  if (!empty($_GET['wrong']))
  print("<div>Неверный пароль!</div>");

?>
  
<form action="" method="post">
<input name="login" placeholder="Логин"/>
  <input name="pass" placeholder="Пароль"/>
  <input type="submit" value="Войти" />
</form>

<?php
}
else 
{
  print($_SERVER['REQUEST_METHOD']);
  $user = 'u47522';
	$pass = '7677055';
	$db = new PDO('mysql:host=localhost;dbname=u47522', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
  $login = $_POST['login'];
	try 
  {
	  $stmt = $db->prepare("SELECT * FROM heroes2 WHERE login = ?");
	  $stmt -> execute([$login]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) 
    {
      header('Location: ?error=1&row='.$_POST['login']);
      exit();
    }
    if(md5($_POST['pass']) !== $row['password']){
      header('Location: ?wrong=1');
      exit();
    }
	}
	catch(PDOException $e)
  {
	  print('Error : ' . $e->getMessage());
	  exit();
	}
  $_SESSION['login'] = $_POST['login'];
  $_SESSION['uid'] = $row['id'];

  header('Location: ./');
}