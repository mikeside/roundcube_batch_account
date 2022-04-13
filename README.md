# roundcube_batch_account

#### 介绍
roundcube邮件系统-批量添加邮件账号插件

#### 软件架构
软件架构说明


#### 安装教程
> 自动安装方式(推荐)：

`composer require mikeside/batch_account
`
> 手动安装方式：
1. cd plugins git pull https://gitee.com/mikehub/roundcube_batch_account.git 或 https://github.com/mikeside/roundcube_batch_account.git batch_account
2. cd batch_account
3. cp config.inc.php.dist config.inc.php
4. 修改config.inc.php配置项 `auth_account`授权账号，就是允许那个邮箱账号有权限添加
5. 修改config.inc.php配置项 `vmail_db_dsn`mysql链接信息
6. 修改roundcube主配置文件：config/config.inc.php 在 `$config['plugins']`数组中添加插件名：`batch_account`

#### 使用说明

1. 登录系统，在设置中会看到一栏 批量添加账号

#### 参与贡献

1.  Fork 本仓库
2.  新建 Feat_xxx 分支
3.  提交代码
4.  新建 Pull Request


#### 特技

1.  使用 Readme\_XXX.md 来支持不同的语言，例如 Readme\_en.md, Readme\_zh.md
2.  Gitee 官方博客 [blog.gitee.com](https://blog.gitee.com)
3.  你可以 [https://gitee.com/explore](https://gitee.com/explore) 这个地址来了解 Gitee 上的优秀开源项目
4.  [GVP](https://gitee.com/gvp) 全称是 Gitee 最有价值开源项目，是综合评定出的优秀开源项目
5.  Gitee 官方提供的使用手册 [https://gitee.com/help](https://gitee.com/help)
6.  Gitee 封面人物是一档用来展示 Gitee 会员风采的栏目 [https://gitee.com/gitee-stars/](https://gitee.com/gitee-stars/)
