## 2019.10.11
开始使用wordpress开发网站。  
1) 版本 wordpress 5.23 , 中文版  
2) 使用git进行管理源码  
3) 运行环境（Cloud Studio）：PHP 7.0.32 和 MySQL 5.7.24 (密码为 coding)， 地址：https://studio.dev.tencent.com/dashboard/workspace  
4) 开发环境：phpstudy（PHP 7.3.4 nts 和 MySQL 5.7.26）； 开发工具： visual studio （以下简称：VS）  

### 1. 步骤：
1.1. 安装git...略  
1.2. 安装phpstudy开发环境...略  
1.3. 安装vs开发工具...略   
   3.1 在vs中配置php环境  
1.4. 下载wordpress 5.23 ，地址：https://wordpress.org/latest.zip， 解压 wordpress 5.23  

   
#### 2. Git 使用
因为前天已经在git新建一个仓库了，昨天一番操作后，因为提交频繁，导致本地的.git文件夹比较大，而且昨天的操作也有错误。所以就想进行初始化本地的仓库和远程的仓库。达到“初始的状态，并且远程的仓库也是初始的，干净的”。

今天的一番操作：
2.1. 在本地git删除全部文件，然后add, commit, push, 这样清空了，本地的文件和远程的仓库文件。但是本地的.git文件夹大小却没有变化，并且还增大了。这不是我想看到的。
2.2. 接着，删除了本地的文件夹myWordpress, 进行了远程git clone，clone后，本地有了myWordPress文件夹以及文件下的.git文件夹，查看.git文件夹也是比较大（初始git init 大小不到1M，这次 clone的 .git文件夹却有14M左右，说明远程的仓库虽然文件已经清空了，但是git还是记录了所有的历史记录，并未达到我原有的目的）
2.3. 尝试在github网站上把myWordPress删除掉，重建。没有找到操作的窗口。
2.4. 利用命令行进行操作：  
   2.4.1 查看远程仓库 : git remote  ## 我的仓库是origin  
   2.4.2 删除远程仓库 ：git remote rm origin  
   2.4.3 再次查看远程仓库 : git remote  ## 仓库origin已经没有了  
   2.4.4 以上命令实在文件夹myWordpress下执行  
   2.4.5 新建仓库： git remote add origin https://github.com/liul21cn/myWordPress.git  
   2.4.6 在文件夹myWordpress下创建 README.md文件，git status, git add . , git commit -m "readme.md", git push ，--结果出错。  
   2.4.7 最终操作: 在 git 网站上，找到该项目，然后点击进入后，找到标签页的“setting” 在最下面有 “Delete this repository”， 就可以把这个项目删除了，然后在重建就可以了。  





