
> 运行环境要求PHP7.1+。

> VUECLI4.4+。

## 使用框架

> thinkphp6.0。

> vue2.0。

> vuecli4.0。

> element ui。

## 目录结构
~~~
前端目录 view/ky-admin
~~~
~~~
数据文件目录：data/keyi.sql
~~~
## 主要功能
* 系统管理
* 文件管理
* 数据管理
* 代码生成(开发中..)




## 运行

~~~

1. 将代码部署到本地或者服务器
2. 修改ky-admin前端的接口地址，地址目录view/ky-admin/.env文件
~~~

```
VUE_APP_PUBLIC_PATH = "http://127.0.0.1:8000"  //将这里换成你自己的访问路径
VUE_APP_API = "http://127.0.0.1:8000/apiadmin/"
```
~~~
3. 将ky-admin用编辑打开
~~~


```
用命令执行
npm install
npm run dev
```
~~~
4. 正式发布
~~~

```
npm run build //前端打包

```
## 版权信息

遵循Apache2开源协议发布，并提供免费使用。

本项目包含的第三方源码和二进制文件之版权信息另行标注。

 