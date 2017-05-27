<?php
return array(
	//'配置项'=>'配置值'
	//数据库配置信息
	'DB_TYPE'   => 'mysqli', // 数据库类型
	'DB_HOST'   => 'localhost', // 服务器地址
	'DB_NAME'   => 'privilege', // 数据库名
	'DB_USER'   => 'root', // 用户名
	'DB_PWD'    => 'root', // 密码
	'DB_PORT'   => 3306, // 端口
	'DB_PREFIX' => 'think_', // 数据库表前缀 
	'DB_CHARSET'=> 'utf8', // 字符集
	'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志 3.2.3新增

	'ADMIN_AUTH_KEY'    => 'admin',
	'USER_AUTH_ON'      => '1',		//是否需要认证
	'USER_AUTH_TYPE'    => '1',		//认证识别号，2为即时验证模式，别的数字为登陆验证
	'RBAC_ROLE_TABLE'   => 'think_role',	//角色表
	'RBAC_USER_TABLE'   => 'think_role_user',	//用户关联角色表，多对多
	'RBAC_ACCESS_TABLE' => 'think_access',		//角色权限关联表，多对多
	'RBAC_NODE_TABLE'   => 'think_node',		//节点表
);