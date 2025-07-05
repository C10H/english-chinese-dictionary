<?php
session_start();
require_once 'database.php';
require_once 'translator.php';

$db = new Database();
$translator = new BaiduTranslator();
$result = '';
$query = '';

if ($_POST['query'] ?? '') {
    $query = trim($_POST['query']);
    
    $translation = $db->searchWord($query);
    
    if ($translation) {
        $result = $translation;
    } else {
        $apiTranslation = $translator->translate($query);
        if ($apiTranslation) {
            $result = $apiTranslation . ' (来自百度翻译)';
        } else {
            $result = '翻译失败，请检查网络连接';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>英汉电子词典</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .search-form {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
        }
        input[type="text"] {
            flex: 1;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            padding: 12px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #0056b3;
        }
        .result {
            background: #e7f3ff;
            padding: 20px;
            border-radius: 5px;
            border-left: 4px solid #007bff;
            font-size: 18px;
            margin-bottom: 20px;
        }
        .admin-link {
            text-align: center;
            margin-top: 20px;
        }
        .admin-link a {
            color: #666;
            text-decoration: none;
        }
        .admin-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>英汉电子词典</h1>
        
        <form method="POST" class="search-form">
            <input type="text" name="query" value="<?php echo htmlspecialchars($query); ?>" 
                   placeholder="请输入中文或英文单词..." required>
            <button type="submit">翻译</button>
        </form>
        
        <?php if ($result): ?>
            <div class="result">
                <strong>翻译结果：</strong><?php echo htmlspecialchars($result); ?>
            </div>
        <?php endif; ?>
        
        <div class="admin-link">
            <a href="admin.php">管理员登录</a>
        </div>
    </div>
</body>
</html>