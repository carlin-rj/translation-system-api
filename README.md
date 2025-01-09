# Translation Management System API

基于 Laravel 的多语言翻译管理系统后端 API

## 功能特性

- 🔐 项目管理
- 🌍 语言管理
- 🔄 翻译文本管理
- 🔄 专注翻译模式
- 🔄 一键机器翻译(多个驱动选择)
- 📦 翻译导入导出

## 环境要求

- PHP >= 8.2
- MySQL >= 5.7

## 快速开始

1. 克隆项目
```bash
git clone https://github.com/carlin-rj/translation-system-api.git
cd translation-system-api
```

2. 安装依赖
```bash
composer install
```

3. 环境配置
```bash
cp .env.example .env
php artisan key:generate
```

4. 配置数据库
```bash
# 编辑 .env 文件，配置数据库连接信息
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=translation
DB_USERNAME=root
DB_PASSWORD=

# 运行数据库迁移
php artisan migrate
```

5. 启动服务
```bash
php artisan octane:start --port=7001
or
php artisan serve --port=7001
```

## 项目结构

```
api/
├── app/               # 应用代码
├── Modules/           # 模块目录
│   ├── Common/        # 公共模块
│   ├── Translation/   # 翻译管理模块
│   └── OpenApi/       # 开放 API 模块
├── config/            # 配置文件
├── database/          # 数据库迁移和种子
├── routes/            # 路由定义
└── tests/             # 测试文件
```

##生成 API 文档
    
```bash
php artisan laravel-data-swagger:generate
```

## API 文档

访问 `/api/documentation` 查看 Swagger API 文档

[MIT License](LICENSE)
