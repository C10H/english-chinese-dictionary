<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: admin.php');
    exit;
}

$db = new Database();
$message = '';

if ($_POST['action'] ?? '') {
    $action = $_POST['action'];
    
    if ($action === 'add') {
        $word = trim($_POST['word']);
        $translation = trim($_POST['translation']);
        if ($word && $translation) {
            if ($db->addWord($word, $translation)) {
                $message = "词条添加成功";
            } else {
                $message = "词条添加失败";
            }
        }
    } elseif ($action === 'delete') {
        $word = trim($_POST['word']);
        if ($word) {
            if ($db->deleteWord($word)) {
                $message = "词条删除成功";
            } else {
                $message = "词条删除失败";
            }
        }
    } elseif ($action === 'logout') {
        session_destroy();
        header('Location: admin.php');
        exit;
    }
}

$words = $db->getAllWords();
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理面板 - 英汉电子词典</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .header {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        h1, h2 {
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }
        button {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-right: 10px;
        }
        button:hover {
            background: #0056b3;
        }
        .btn-danger {
            background: #dc3545;
        }
        .btn-danger:hover {
            background: #c82333;
        }
        .btn-secondary {
            background: #6c757d;
        }
        .btn-secondary:hover {
            background: #545b62;
        }
        .message {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
        }
        .action-form {
            display: inline;
        }
        .add-form {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 10px;
            align-items: end;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>词典管理面板</h1>
        <div>
            <span>欢迎，<?php echo htmlspecialchars($_SESSION['username']); ?></span>
            <form method="POST" style="display: inline; margin-left: 10px;">
                <input type="hidden" name="action" value="logout">
                <button type="submit" class="btn-secondary">退出登录</button>
            </form>
        </div>
    </div>

    <?php if ($message): ?>
        <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <div class="container">
        <h2>添加新词条</h2>
        <form method="POST" class="add-form">
            <input type="hidden" name="action" value="add">
            <div class="form-group">
                <label for="word">单词：</label>
                <input type="text" id="word" name="word" required>
            </div>
            <div class="form-group">
                <label for="translation">翻译：</label>
                <input type="text" id="translation" name="translation" required>
            </div>
            <div>
                <button type="submit">添加词条</button>
            </div>
        </form>
    </div>

    <div class="container">
        <h2>现有词条 (共 <?php echo count($words); ?> 条)</h2>
        <table>
            <thead>
                <tr>
                    <th>单词</th>
                    <th>翻译</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($words as $word): ?>
                <tr>
                    <td><?php echo htmlspecialchars($word['word']); ?></td>
                    <td><?php echo htmlspecialchars($word['translation']); ?></td>
                    <td><?php echo htmlspecialchars($word['created_at']); ?></td>
                    <td>
                        <form method="POST" class="action-form" 
                              onsubmit="return confirm('确定要删除词条「<?php echo htmlspecialchars($word['word']); ?>」吗？')">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="word" value="<?php echo htmlspecialchars($word['word']); ?>">
                            <button type="submit" class="btn-danger">删除</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div style="text-align: center; margin-top: 20px;">
        <a href="index.php" style="color: #666; text-decoration: none;">返回词典首页</a>
    </div>
</body>
</html>