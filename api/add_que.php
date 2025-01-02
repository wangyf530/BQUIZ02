<?php include_once "db.php";

// $_POST['subject']

$QUE->save(['text'=>$_POST['subject'],'main_id'=>0,'vote'=>0]);

$subject_id = q("SELECT id FROM que WHERE text='{$_POST['subject']}'")[0][0];

// $_POST['options']
foreach($_POST['options'] as $opt){
    $QUE->save([
        'text' => $opt,
        'main_id' => $subject_id,
        'vote'=>0
    ]);
}
