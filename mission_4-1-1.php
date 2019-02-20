<?php
$named=$_POST['content'];
$commented=$_POST['content2'];
$deleted=$_POST['number'];
$edited=$_POST['edit'];
$editnumber=$_POST['content3'];
$passed=$_POST['pass'];
$pass2=$_POST['pass2'];
$pass3=$_POST['pass3'];
$timed=date('Y/n/d H:i:s');

//データベース接続
$dsn='データベース名';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>
PDO::ERRMODE_WARNING));

//テーブル作成
$sql="CREATE TABLE IF NOT EXISTS mission_4_1_1"
."("
."id INT auto_increment,"
."name char(32),"
."comment TEXT,"
."time DATETIME,"
."pass INT,"
."primary key(id)"
.");";
$stmt=$pdo->query($sql);
	
//テーブル作成確認
$sql1='SHOW TABLES';
$result=$pdo->query($sql1);
	foreach($result as $row){
	echo $row[0];
	echo'<br>';
	}
echo"<hr>";
	
//テーブル　中身　確認
$sql2='SHOW CREATE TABLE mission_4_1_1';
$result=$pdo->query($sql2);
foreach($result as $row1){
	echo $row1[1];
}
echo"<hr>";
if(!empty($editnumber)){
	$sql7="SELECT*FROM mission_4_1_1 WHERE id=$editnumber";
	$stmt=$pdo->query($sql7);
	foreach($stmt as $ROW){
		if($ROW['id']==$editnumber and $ROW['pass']==$passed){
			$time=$timed;
			$pass=$passed;
			$name=$named;
			$comment=$commented;

			$sql4="update mission_4_1_1 set name=:name,comment=:comment,time=:time,pass=:pass where id='$editnumber'";

			$stmt=$pdo->prepare($sql4);
			$stmt->bindValue(':name',$name,PDO::PARAM_STR);
			$stmt->bindValue(':comment',$comment,PDO::PARAM_STR);
			$stmt->bindValue(':time',$time,PDO::PARAM_INT);
			$stmt->bindValue(':pass',$pass,PDO::PARAM_INT);

			$stmt->execute();
		}
	}


}
				
elseif(!empty($named)and empty ($editnumber)){
	$sql3=$pdo->prepare("INSERT INTO mission_4_1_1(name,comment,time,pass) VALUES(:name,:comment,:time,:pass)");
	$time=$timed;
	$pass=$passed;
	$name=$named;
	$comment=$commented;

	$sql3->bindValue(':name',$name,PDO::PARAM_STR);
	$sql3->bindValue(':comment',$comment,PDO::PARAM_STR);
	$sql3->bindValue(':time',$time,PDO::PARAM_STR);
	$sql3->bindValue(':pass',$pass,PDO::PARAM_INT);
				
				
	$sql3 -> execute();
}

elseif(!empty($pass3)){
	$sql7="SELECT*FROM mission_4_1_1 WHERE id=$edited and pass=$pass3";
	$stmt=$pdo->query($sql7);
	foreach($stmt as $row_1){
	}
}

elseif(!empty($pass2)){
	$sql8="SELECT*FROM mission_4_1_1 WHERE id=$deleted";
	$stmt=$pdo->query($sql8);
		foreach($stmt as $row){
			if($row['id']==$deleted){
				$id="$deleted";
				$sql5='delete from mission_4_1_1 where id=:id';
				$stmt=$pdo->prepare($sql5);
				$stmt->bindParam(':id',$id,PDO::PARAM_INT);
				$stmt->execute();
			}
		}
}



$sql6='SELECT*FROM mission_4_1_1';
$stmt=$pdo->query($sql6);
$results=$stmt->fetchAll();
	foreach($results as $row2){
		//$rowの中にはテーブルのカラム名が入る
		echo $row2['id'].',';
		echo $row2['name'].',';
		echo $row2['comment'].',';
		echo $row2['time'].'<br>';
	}
?>

<html>
	<head>
	<meta charset="utf-8">
	</head>
	<body>
		<form method="POST" action="mission_4-1.php">
			<input type="text" name="content" placeholder="名前" value="<?php echo $row_1[name];?>"><br>
			<input type="text" name="content2" placeholder="コメント" value="<?php echo $row_1[comment];?>"><br>
			<input type="hidden" name="content3" value="<?php echo $row_1[id];?>">
			<input type="password" name="pass" placeholder="パスワード">
			<input type="submit" value="送信"><br>
			<br>
			<input type="text" name="number" placeholder="削除対象番号"><br>
			<input type="password" name="pass2" placeholder="パスワード">
			<input type="submit" value="削除"><br>
			<br>
			<input type="text" name="edit" placeholder="編集対象番号"><br>
			<input type="password" name="pass3" placeholder="パスワード">
			<input type="submit" value="編集">
		</form>
	</body>
</html>