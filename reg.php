<?php 
error_reporting(E_ALL^E_NOTICE^E_DEPRECATED^E_STRICT);
$pdo=new PDO("mysql:host=localhost;dbname=web13",'root',"");
$pdo->query("set names utf8");
// var_dump($_POST);
// var_dump($_FILES);
//接受前台用户名失去焦点是的验证数据
if ($_POST['action']=="checkUsername"){
//     var_dump($_POST);
    $result3=$pdo->query("select *from member where username='".$_POST['username']."'");
    $oneUser=$result3->fetchAll(PDO::FETCH_OBJ);
    if($oneUser[0]){
        echo "taken";
        return false;
    }
}
if ($_POST['action']=="reg"){
    $result2=$pdo->query("select *from member where username='".$_POST['username']."'");
    $oneUser=$result2->fetchAll(PDO::FETCH_OBJ);
    if($oneUser[0]){
        echo "taken";
        return false;
    }
    //检测uploads目录是否存在
    $uploads="uploads";
    if(!file_exists($uploads)){
        //创建目录
        mkdir($uploads);
    }
    $pic=null;
    //判断是否上传了文件
    if (is_uploaded_file($_FILES['pic']['tmp_name'])){
        //处理上传
      $arr=explode(".", $_FILES['pic']['name']);
      $newname=rand(100,999).date('YmdHis').".".$arr[count($arr)-1];
//       var_dump($newname);
        if(move_uploaded_file($_FILES['pic']['tmp_name'],$uploads."/".$newname)){
            //echo "ok";
            $pic=$newname;
            }else{
                
          }
        }else {
            $pic="default.jpeg";
        }
    $sql="insert into member(
                            username,
                            pwd,
                            email,
                            pic,
                            regTime
                        )values(
                            '".$_POST['username']."',
                            '".md5($_POST['pwd'])."',
                            '".$_POST['email']."',
                            '".$pic."',
                            '".date('Y-m-d H:i:s')."'
                        )";
    $result=$pdo->exec($sql);
    if ($result){
        echo "ok";
    }else {
        echo "failed";
    }
}
?>