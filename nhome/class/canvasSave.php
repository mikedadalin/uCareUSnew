<?php 
    session_start();
    $HospNo = $_POST['HospNo'];
    $img = $_POST['img'];
    $Date = $_POST['Date'];
    $img = str_replace('data:image/png;base64,','', $img);// 需注意 data url 格式 與來源是否相符 ex:image/jpeg
    $data = base64_decode($img);//解base64碼
    $picFolder = '../uploadfile/'.$_SESSION['nOrgID_lwj'].'/'.$HospNo.'/nurseform60_pic'.'/'.$Date;
    if(!file_exists($picFolder)){
         mkdir($picFolder, 0777, true);
    }
    $name = date("Ymd");
    $file = '../uploadfile/'.$_SESSION['nOrgID_lwj'].'/'.$HospNo.'/nurseform60_pic'.'/'.$Date.'/Periodic Skin Check.png';//檔名 包含資料夾路徑 請記得此資料夾需 777 權限 方可寫入圖檔
    $success = file_put_contents($file, $data);
 ?>