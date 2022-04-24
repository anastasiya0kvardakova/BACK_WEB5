<style>
  body{
    margin: 0;
    padding: 0;
    overflow: hidden;
  }
  body 
  {
    display: flex;
    justify-content: center;
    align-items: center;
  }
  #form
  {
    margin: 0 auto;
    text-align: center;
    width: 100%;
    border: 1px solid black;
    background: blanchedalmond;
    padding: 15px;
  }
  input
  {
    margin-bottom: 3px;
  }
  input
  {
  height: calc(2.25rem + 2px);
  font-family: inherit;
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.5;
  color: #212529;
  background-color: #fff;
  background-clip: padding-box;
  border: 1px solid #bdbdbd;
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
  padding-left: 13px;
  }
  input:first-child
  {
    margin-top: 20px;
  }
  .button-4 
  {
    appearance: none;
    background-color: #FAFBFC;
    border: 1px solid rgba(27, 31, 35, 0.15);
    border-radius: 6px;
    box-shadow: rgba(27, 31, 35, 0.04) 0 1px 0, rgba(255, 255, 255, 0.25) 0 1px 0 inset;
    box-sizing: border-box;
    color: #24292E;
    cursor: pointer;
    display: inline-block;
    font-family: -apple-system, system-ui, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji";
    font-size: 14px;
    font-weight: 500;
    line-height: 20px;
    list-style: none;
    padding: 6px 16px;
    position: relative;
    transition: background-color 0.2s cubic-bezier(0.3, 0, 0.5, 1);
    user-select: none;
    -webkit-user-select: none;
    touch-action: manipulation;
    vertical-align: middle;
    white-space: nowrap;
    word-wrap: break-word;
  }

  .button-4:hover 
  {
    background-color: #8ac8ff;
    text-decoration: none;
    transition-duration: 0.1s;
  }

  .button-4:disabled 
  {
    background-color: #f0f8ff;
    border-color: rgba(27, 31, 35, 0.15);
    color: #959DA5;
    cursor: default;
  }

  .button-4:active
   {
    background-color: #EDEFF2;
    box-shadow: rgba(225, 228, 232, 0.2) 0 1px 0 inset;
    transition: none 0s;
  }

  .button-4:focus
   {
    outline: 1px transparent;
  }

  .button-4:before 
  {
    display: none;
  }

  .button-4:-webkit-details-marker 
  {
    display: none;
  }
  textarea 
  {
    height: 150px;
    width: 33%;
    padding: 12px 20px;
    box-sizing: border-box;
    border: 2px solid #ccc;
    border-radius: 4px;
    background-color: #f8f8f8;
    resize: none;
  }
  input[type="radio"], input[type="checkbox"]
  {
    height: 15px;
    color: red;
  }
  .error 
  {
  border: 2px solid red;
}
</style>
<?php
if (!empty($messages)) 
{
  print('<div id="messages">');
  foreach ($messages as $message) 
  {
    print($message);
  }
  print('</div>');
}
if(!empty($_COOKIE[session_name()]) && !empty($_SESSION['login']))
  print('Привет, '.$_SESSION['login'].'   <a href="logout.php">Выйти</a>');
else{
  print('<a href="login.php">Войти</a>');}
?>
<form id="form" method="POST" action="">
          <label> <input type="text" placeholder="Имя" name="fio" <?php if ($errors['fio']) {print 'class="error"';} ?> value="<?php print $values['fio']; ?>"/><br /></label>
          <label><input type="email" placeholder="Email" name="email" <?php if ($errors['email']) {print 'class="error"';} ?> value="<?php print $values['email']; ?>"/><br /></label>
          <label><input type="date" name="date" <?php if ($errors['date']) {print 'class="error"';} ?> value="<?php print $values['date'];?>"/><br /></label>
          <label <?php if ($errors['gender']) {print 'class="error"';} ?>>
          <label>
            Пол
            <input type="radio" name="gender" value="male" <?php if($values['gender'] == 'male'){print 'checked';};?>/>Мужской
          </label>
          <label>
            <input type="radio" name="gender" value="female" <?php if($values['gender'] == 'female'){print 'checked';};?>/>Женский
          </label>
          </label>
          <br />
          <label <?php if ($errors['arms']) {print 'class="error"';} ?>>
          <label>
          Количество конечностей
            <input type="radio" name="arms" value="1" <?php if($values['arms'] == '1'){print 'checked';};?>/>1
          </label>
          <label> <input type="radio" name="arms" value="2" <?php if($values['arms'] == '2'){print 'checked';};?>/>2 </label>
          <label>
            <input type="radio" name="arms" value="more" <?php if($values['arms'] == '3'){print 'checked';};?>/>3
          </label>
          <label>
            <input type="radio" name="arms" value="4" <?php if($values['arms'] == '4'){print 'checked';};?>/>4
          </label>
          </label>
          <br /><br/>
          <label>
          Выберите сверхспособность<br />
            <select name="arg[]" multiple="multiple" <?php if ($errors['arg']) {print 'class="error"';} ?>>
              <option value="god" <?php $a = explode(',',$values['arg']); foreach ($a as $key){if($key == 'god'){print 'selected';}}?>>Локи (Бессмертие)</option>
              <option value="wall"<?php $a = explode(',',$values['arg']); foreach ($a as $key){if($key == 'wall'){print 'selected';}}?>>Вижн (Прохождение сквозь стены)</option>
              <option value="fly"<?php $a = explode(',',$values['arg']); foreach ($a as $key){if($key == 'fly'){print 'selected';}}?>>Доктор Стрендж (Левитация)</option>
            </select> </label
          ><br /><br/>
          <label> Расскажите о себе<br/> <textarea name="about"<?php if ($errors['about']) {print 'class="error"';} ?>><?php print $values['about']; ?></textarea></label><br />
          <label <?php if ($errors['check']) {print 'class="error"';} ?>><input type="checkbox" name="check" value="Yes"/>С контрактом ознакомлен(а)</label><br /><br/>
          <button type="submit" class="button-4">Отправить</button>
</form>