-- Create dictionary table
CREATE TABLE IF NOT EXISTS dictionary (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    word TEXT NOT NULL UNIQUE,
    translation TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Insert initial dictionary data
INSERT OR IGNORE INTO dictionary (word, translation) VALUES ('hello', '你好');
INSERT OR IGNORE INTO dictionary (word, translation) VALUES ('test', '测试');

-- Insert initial user data
INSERT OR IGNORE INTO users (username, password) VALUES ('admin', 'password');