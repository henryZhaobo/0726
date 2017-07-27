<?php
error_reporting(E_ALL^E_NOTICE^E_DEPRECATED^E_STRICT);
//延缓代码执行
sleep(1);
// var_dump($_GET);
$pdo=new PDO("mysql:host=localhost;dbname=web13",'root',"");
$pdo->query("set names utf8");
$sql="select *from admin 
      where username='".$_POST['username']."' 
      and pwd='".md5($_POST['pwd'])."'";
$result=$pdo->query($sql);
$data=$result->fetchAll(PDO::FETCH_OBJ);
if($data[0]){
    echo "ok";
}else {
    echo "failed";
}
?>