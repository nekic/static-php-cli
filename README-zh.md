# static-php-cli

Build single static PHP binary, with PHP project together, with popular extensions included.

🌐 **[中文](README-zh.md)** | **[English](README.md)**

编译纯静态的 PHP Binary 二进制文件，带有各种扩展，让 PHP-cli 应用变得更便携！（cli SAPI）

<img width="600" alt="截屏2023-05-02 15 53 13" src="https://user-images.githubusercontent.com/20330940/235610282-23e58d68-bd35-4092-8465-171cff2d5ba8.png">

同时可以使用 micro 二进制文件，将 PHP 源码和 PHP 二进制构建为一个文件分发！（micro SAPI）

<img width="600" alt="截屏2023-05-02 15 52 33" src="https://user-images.githubusercontent.com/20330940/235610318-2ef4e3f1-278b-4ca4-99f4-b38120efc395.png">

> 该 SAPI 源自 [dixyes/phpmicro](https://github.com/dixyes/phpmicro) 的 [Fork 仓库](https://github.com/static-php/phpmicro)。

[![Version](https://img.shields.io/badge/Version-2.0--rc8-pink.svg?style=flat-square)]()
[![License](https://img.shields.io/badge/License-MIT-blue.svg?style=flat-square)]()
[![](https://img.shields.io/github/actions/workflow/status/static-php/static-php-cli-hosted/build-php-common.yml?branch=refactor&label=Build%20Common%20Extensions&style=flat-square)](https://github.com/static-php/static-php-cli-hosted/actions/workflows/build-php-common.yml)
[![](https://img.shields.io/badge/Extension%20Counter-65+-yellow.svg?style=flat-square)]()
[![](https://img.shields.io/github/search/crazywhalecc/static-php-cli/TODO?label=TODO%20Counter&style=flat-square)]()

> 项目名称是 static-php-cli，但其实支持 cli、fpm、micro 和 embed SAPI 😎

## 文档

目前 README 编写了基本用法。有关 static-php-cli 所有的功能，请点击这里查看文档：<https://static-php.dev>。

## 自托管直接下载

如果你不想自行编译 PHP，可以从本项目现有的示例 Action 下载 Artifact，也可以从自托管的服务器下载。

- [扩展组合 - common](https://dl.static-php.dev/static-php-cli/common/)：common 组合包含了约 [30+](https://dl.static-php.dev/static-php-cli/common/README.txt) 个常用扩展，体积为 22MB 左右。
- [扩展组合 - bulk](https://dl.static-php.dev/static-php-cli/bulk/)：bulk 组合包含了 [50+](https://dl.static-php.dev/static-php-cli/bulk/README.txt) 个扩展，体积为 70MB 左右。
- [扩展组合 - minimal](https://dl.static-php.dev/static-php-cli/minimal/)：minimal 组合包含了 [5](https://dl.static-php.dev/static-php-cli/minimal/README.txt) 个扩展，体积为 6MB 左右。

## 使用 static-php-cli 构建 PHP

### 编译环境需求

是的，本项目采用 PHP 编写，编译前需要一个 PHP 环境，比较滑稽。
但本项目默认可通过自身构建的 micro 和 static-php 二进制运行，其他只需要包含 mbstring、pcntl 扩展和 PHP 版本大于等于 8.1 即可。

下面是架构支持情况，:octocat: 代表支持 GitHub Action 构建，:computer: 代表支持本地构建，空 代表暂不支持。

|         | x86_64               | aarch64              |
|---------|----------------------|----------------------|
| macOS   | :octocat: :computer: | :computer:           |
| Linux   | :octocat: :computer: | :octocat: :computer: |
| Windows |                      |                      |
| FreeBSD | :computer:           | :computer:           |

> macOS-arm64 因 GitHub 暂未提供 arm runner，如果要构建 arm 二进制，可以使用手动构建。

目前支持编译的 PHP 版本为：`7.3`，`7.4`，`8.0`，`8.1`，`8.2`，`8.3`。

### 支持的扩展情况

请先根据下方扩展列表选择你要编译的扩展。

- [扩展支持列表](https://static-php.dev/zh/guide/extensions.html)
- [编译命令生成器](https://static-php.dev/zh/guide/cli-generator.html)

> 如果这里没有你需要的扩展，可以提交 Issue。

### 使用 Actions 构建

使用 GitHub Action 可以方便地构建一个静态编译的 PHP，同时可以自行定义要编译的扩展。

1. Fork 本项目。
2. 进入项目的 Actions，选择 CI。
3. 选择 `Run workflow`，填入你要编译的 PHP 版本、目标类型、扩展列表。（扩展列表使用英文逗号分割，例如 `bcmath,curl,mbstring`）
4. 等待大约一段时间后，进入对应的任务中，获取 `Artifacts`。

如果你选择了 `debug`，则会在构建时输出所有日志，包括编译的日志，以供排查错误。

### 手动构建（使用 SPC 二进制）

本项目提供了一个 static-php-cli 的二进制文件，你可以直接下载对应平台的二进制文件，然后使用它来构建静态的 PHP。目前 `spc` 二进制支持的平台有 Linux 和 macOS。

下面是从 GitHub Action 下载的方法：

1. 进入 [GitHub Action](https://github.com/crazywhalecc/static-php-cli/actions/workflows/release-build.yml)。
2. 选择一个最新的构建任务，进入后选择 `Artifacts`，下载对应平台的二进制文件。
3. 解压 `.zip` 文件。解压后，为其添加执行权限：`chmod +x ./spc`。

你也可以从自托管的服务器下载二进制文件：[进入](https://dl.static-php.dev/static-php-cli/spc-bin/nightly/)。

### 手动构建（使用源码）

先克隆本项目：

```bash
git clone https://github.com/crazywhalecc/static-php-cli.git
```

如果你本机没有安装 PHP，你需要先使用包管理（例如 brew、apt、yum、apk 等）安装 php。

你也可以通过 `bin/setup-runtime` 命令下载静态编译好的 php-cli 和 Composer。下载的 php 和 Composer 将保存为 `bin/php` 和 `bin/composer`。

```bash
cd static-php-cli
chmod +x bin/setup-runtime
./bin/setup-runtime

# 使用独立的 php 运行 static-php-cli
./bin/php bin/spc

# 使用 composer
./bin/php bin/composer

# 初始化本项目
cd static-php-cli
composer update
chmod +x bin/spc
```

### 使用 static-php-cli 命令行程序

下面是使用 static-php-cli 编译静态 php 和 micro 的基础用法：

> 如果你使用的是打包好的 `spc` 二进制，你需要将下列命令的 `bin/spc` 替换为 `./spc`。

```bash
# 检查环境依赖，并根据提示的命令安装缺失的编译工具
./bin/spc doctor
# 拉取所有依赖库
./bin/spc fetch --all
# 只拉取编译指定扩展需要的所有依赖
./bin/spc download --for-extensions=openssl,pcntl,mbstring,pdo_sqlite
# 构建包含 bcmath,openssl,tokenizer,sqlite3,pdo_sqlite,ftp,curl 扩展的 php-cli 和 micro.sfx
./bin/spc build "bcmath,openssl,tokenizer,sqlite3,pdo_sqlite,ftp,curl" --build-cli --build-micro
```

你也可以使用参数 `--with-php=x.y` 来指定下载的 PHP 版本，目前支持 7.3 ~ 8.3：

```bash
# 优先考虑使用 >= 8.0 的 PHP 版本，因为 phpmicro 不支持在 PHP7 中构建
./bin/spc download --with-php=8.2 --all
```

其中，目前支持构建 cli，micro，fpm 三种静态二进制，使用以下参数的一个或多个来指定编译的 SAPI：

- `--build-cli`：构建 cli 二进制
- `--build-micro`：构建 phpmicro 自执行二进制
- `--build-fpm`：构建 fpm
- `--build-embed`：构建 embed（libphp）
- `--build-all`：构建所有

如果出现了任何错误，可以使用 `--debug` 参数来展示完整的输出日志，以供排查错误：

```bash
./bin/spc build openssl,pcntl,mbstring --debug --build-all
./bin/spc fetch --all --debug
```

此外，默认编译的 PHP 为 NTS 版本。如需编译线程安全版本（ZTS），只需添加参数 `--enable-zts` 即可。

```bash
./bin/spc build openssl,pcntl --build-all --enable-zts
```

同时，你也可以使用参数 `--no-strip` 来关闭裁剪，关闭裁剪后可以使用 gdb 等工具调试，但这样会让静态二进制体积变大。

## 不同 SAPI 的使用

### 使用 cli

> php-cli 是一个静态的二进制文件，类似 Go、Rust 语言编译后的单个可移植的二进制文件。

采用参数 `--build-cli` 或`--build-all` 参数时，最后编译结果会输出一个 `./php` 的二进制文件，此文件可分发、可直接使用。
该文件编译后会存放在 `buildroot/bin/` 目录中，名称为 `php`，拷贝出来即可。

```bash
cd buildroot/bin/
./php -v                # 检查版本
./php -m                # 检查编译的扩展
./php your_code.php     # 运行代码
./php your_project.phar # 运行打包为 phar 单文件的项目
```

### 使用 micro

> phpmicro 是一个提供自执行二进制 PHP 的项目，本项目依赖 phpmicro 进行编译自执行二进制。详见 [dixyes/phpmicro](https://github.com/dixyes/phpmicro)。

采用项目参数 `--build-micro` 或 `--build-all` 时，最后编译结果会输出一个 `./micro.sfx` 的文件，此文件需要配合你的 PHP 源码使用。
该文件编译后会存放在 `buildroot/bin/` 目录中，拷贝出来即可。

使用时应准备好你的项目源码文件，可以是单个 PHP 文件，也可以是 Phar 文件。

```bash
echo "<?php echo 'Hello world' . PHP_EOL;" > code.php
cat micro.sfx code.php > single-app && chmod +x single-app
./single-app
```

如果打包 PHAR 文件，仅需把 code.php 更换为 phar 文件路径即可。
你可以使用 [box-project/box](https://github.com/box-project/box) 将你的 CLI 项目打包为 Phar，
然后将它与 phpmicro 结合，生成独立可执行的二进制文件。

```bash
# 使用 static-php-cli 生成的 micro.sfx 结合，也可以直接使用 cat 命令结合它们
bin/spc micro:combine my-app.phar
cat buildroot/bin/micro.sfx my-app.phar > my-app && chmod +x my-app

# 使用 micro:combine 结合可以将 INI 选项注入到二进制中
bin/spc micro:combine my-app.phar -I "memory_limit=4G" -I "disable_functions=system" --output my-app-2
```

> 有些情况下的 phar 文件或 PHP 项目可能无法在 micro 环境下运行。

### 使用 fpm

采用项目参数 `--build-fpm` 或 `--build-all` 时，最后编译结果会输出一个 `./php-fpm` 的文件。
该文件存放在 `buildroot/bin/` 目录，拷贝出来即可使用。

在正常的 Linux 发行版和 macOS 系统中，安装 php-fpm 后包管理会自动生成默认的 fpm 配置文件。
因为 php-fpm 必须指定配置文件才可启动，本项目编译的 php-fpm 不会带任何配置文件，所以需自行编写 `php-fpm.conf` 和 `pool.conf` 配置文件。

指定 `php-fpm.conf` 可以使用命令参数 `-y`，例如：`./php-fpm -y php-fpm.conf`。

### 使用 embed

采用项目参数 `--build-embed` 或 `--build-all` 时，最后编译结果会输出一个 `libphp.a`、`php-config` 以及一系列头文件，存放在 `buildroot/`，你可以在你的其他代码中引入它们。

如果你知道 [embed SAPI](https://github.com/php/php-src/tree/master/sapi/embed)，你应该知道如何使用它。对于有可能编译用到引入其他库的问题，你可以使用 `buildroot/bin/php-config` 来获取编译时的配置。

另外，有关如何使用此功能的高级示例，请查看[如何使用它构建 FrankenPHP 的静态版本](https://github.com/dunglas/frankenphp/blob/main/docs/static.md)。

## 贡献

如果缺少你需要的扩展，可发起 Issue。如果你对本项目较熟悉，也欢迎为本项目发起 Pull Request。

另外，添加新扩展的贡献方式，可以参考下方 `进阶`。

如果你想贡献文档内容，请到项目仓库 [static-php/static-php-cli-docs](https://github.com/static-php/static-php-cli-docs) 贡献。

## 赞助本项目

你可以在 [我的个人赞助页](https://github.com/crazywhalecc/crazywhalecc/blob/master/FUNDING.md) 支持我和我的项目。

## 开源协议

本项目依据旧版本惯例采用 MIT License 开源，部分扩展的集成编译命令参考或修改自以下项目：

- [dixyes/lwmbs](https://github.com/dixyes/lwmbs)（木兰宽松许可证）
- [swoole/swoole-cli](https://github.com/swoole/swoole-cli)（Apache 2.0 LICENSE、SWOOLE-CLI LICENSE）

因本项目的特殊性，使用项目编译过程中会使用很多其他开源项目，例如 curl、protobuf 等，它们都有各自的开源协议。
请在编译完成后，使用命令 `bin/spc dump-license` 导出项目使用项目的开源协议，并遵守对应项目的 LICENSE。

## 进阶

本项目重构分支为模块化编写。如果你对本项目感兴趣，想加入开发，可以参照文档的 [贡献指南](https://static-php.dev) 贡献代码或文档。
