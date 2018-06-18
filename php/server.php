<?php
//服务器
error_reporting( E_ALL ); //设置报错等级
set_time_limit( 0 ); //设置脚本执行不超时

//创建服务端套接字
$server_socket = socket_create( AF_INET, SOCK_STREAM, SOL_TCP );
if ( ! $server_socket ) {
	echo "server socket create failed. error:  " . socket_strerror( socket_last_error( $server_socket ) ), "\n";
	exit();
} else {
	echo "server socket created success!\n";
}

//绑定IP地址
$ip           = "127.0.0.1";  //服务器IP地址
$port         = "6666";     //服务器开启的tcp端口
$bind_success = socket_bind( $server_socket, $ip, $port );
if ( ! $bind_success ) {
	echo "ip address or port bind failed. error: " . socket_strerror( socket_last_error( $server_socket ) );
	exit();
}

//开始监听
$listen_success = socket_listen( $server_socket, SOMAXCONN );//指定最大排队连接数
if ( ! $listen_success ) {
	echo "listen failed,error:  " . socket_strerror( socket_last_error( $server_socket ) ), "\n";
}

//接收连接
$connected    = true;
$read_length  = 1024;
$response_str = "hello from server";
while ( $connected ) {
	//接收客户端输入
	$connection = socket_accept( $server_socket );
	$rcv_str    = socket_read( $connection, $read_length );
	if ( ! $rcv_str ) {
		echo "nothing received";
	} else {
		echo "server received:" . $rcv_str;
	}
	//响应客户端
	$res_success = socket_write( $connection, $response_str, strlen( $response_str ) );
	if ( ! $res_success ) {
		echo "response failed";
	}
}
