# 英汉电子词典系统

一个基于 Apache + PHP + SQLite 的双语电子词典系统，支持中英文自动识别、本地词典查询和百度翻译API备用查询。

## 功能特性

- 🔍 **智能语言检测**: 自动识别输入的中文或英文
- 📚 **本地词典**: 基于SQLite的高效本地词典数据库
- 🌐 **在线翻译**: 集成百度翻译API作为词典补充
- 👨‍💼 **管理后台**: 完整的词典管理系统，支持增删改查
- 🔐 **安全认证**: 管理员登录验证系统
- 🐳 **容器部署**: 支持Docker一键部署

## 技术栈

- **Web服务器**: Apache 2.4
- **后端语言**: PHP 8.1
- **数据库**: SQLite 3
- **前端**: HTML5 + CSS3 + JavaScript
- **容器化**: Docker

## 快速开始

### 方式一：Docker 部署（推荐）

1. 克隆项目
```bash
git clone https://github.com/C10H/dictionary_lap.git
cd dictionary_lap
```

2. 构建Docker镜像
```bash
docker build -t c10h15n/dictionary-app .
```

3. 运行容器
```bash
docker run -d -p 8080:80 --name dictionary c10h15n/dictionary-app
```

4. 访问应用
- 主页：http://localhost:8080
- 管理后台：http://localhost:8080/admin.php

### 方式二：本地部署

#### 环境要求
- Apache 2.4+
- PHP 8.0+
- SQLite 3
- cURL 扩展

#### 安装步骤

1. 克隆项目到Web目录
```bash
cd /var/www/html
git clone https://github.com/C10H/dictionary_lap.git .
```

2. 设置权限
```bash
chown -R www-data:www-data .
chmod 666 dictionary.db
```

3. 启用Apache模块
```bash
a2enmod rewrite
a2enmod headers
systemctl restart apache2
```

4. 访问应用
- 主页：http://your-domain
- 管理后台：http://your-domain/admin.php

## 使用说明

### 主要功能

#### 1. 词典查询
- 在首页输入框中输入中文或英文单词
- 系统自动检测语言并查询翻译
- 优先查询本地词典，如未找到则调用百度翻译API

#### 2. 管理后台
- 访问 `/admin.php` 进入管理界面
- 默认账号：`admin` / `password`
- 支持添加、删除、修改词典条目

### API配置

项目已配置百度翻译API：
- APP ID: `20240531002066782`
- 密钥: `2UYrEDwvtMgOShDLo3u8`

如需修改API配置，请编辑 `translator.php` 文件。

## 数据库结构

### dictionary 表
| 字段 | 类型 | 说明 |
|------|------|------|
| id | INTEGER | 主键，自增 |
| word | TEXT | 单词/词组 |
| translation | TEXT | 翻译 |
| created_at | DATETIME | 创建时间 |

### users 表
| 字段 | 类型 | 说明 |
|------|------|------|
| id | INTEGER | 主键，自增 |
| username | TEXT | 用户名 |
| password | TEXT | 密码 |
| created_at | DATETIME | 创建时间 |

## 文件结构

```
dictionary_lap/
├── index.php              # 主页面
├── admin.php              # 管理员登录页
├── admin_panel.php        # 管理面板
├── database.php           # 数据库操作类
├── translator.php         # 百度翻译API类
├── dictionary.db          # SQLite数据库文件
├── init_database.sql      # 数据库初始化脚本
├── .htaccess             # Apache配置
├── apache-site.conf      # Apache虚拟主机配置
├── Dockerfile            # Docker构建文件
├── .dockerignore         # Docker忽略文件
└── README.md             # 项目说明
```

## 安全特性

- SQL注入防护（PDO预处理语句）
- XSS防护（输出转义）
- 会话管理
- 数据库文件访问限制
- 安全HTTP头设置

## 开发说明

### 添加新功能
1. 在对应的PHP文件中添加功能代码
2. 更新数据库结构（如需要）
3. 测试功能完整性
4. 更新文档

### 自定义样式
所有样式都内嵌在PHP文件中，可以直接修改相应的CSS部分。

## 部署到云端

### Docker Hub
```bash
# 推送到Docker Hub
docker tag c10h15n/dictionary-app c10h15n/dictionary-app:latest
docker push c10h15n/dictionary-app:latest
```

### GitHub Actions
项目支持GitHub Actions自动化部署，推送代码后自动构建Docker镜像。

## 故障排除

### 常见问题

1. **数据库权限错误**
   ```bash
   chmod 666 dictionary.db
   chown www-data:www-data dictionary.db
   ```

2. **Apache重写规则不生效**
   ```bash
   a2enmod rewrite
   systemctl restart apache2
   ```

3. **百度翻译API调用失败**
   - 检查网络连接
   - 验证API密钥是否正确
   - 确认API调用次数未超限

## 贡献指南

1. Fork 项目
2. 创建功能分支
3. 提交更改
4. 推送到分支
5. 创建 Pull Request

## 许可证

本项目采用 MIT 许可证 - 查看 [LICENSE](LICENSE) 文件了解详情。

## 联系方式

- GitHub: [@C10H](https://github.com/C10H)
- Docker Hub: [c10h15n](https://hub.docker.com/u/c10h15n)

## 更新日志

### v1.0.0
- 初始版本发布
- 基础词典功能
- 管理后台
- Docker支持