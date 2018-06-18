<?php
//客户端
error_reporting( E_ALL );
set_time_limit( 0 ); //设置脚本执行不超时

//服务端参数
$server_ip   = '127.0.0.1';
$server_port = '6666';

//创建客户端套接字
$client_socket = socket_create( AF_INET, SOCK_STREAM, SOL_TCP ); //创建客户端socket
if ( ! $client_socket ) {
	echo "client socket create failed.error: " . socket_strerror( socket_last_error( $client_socket ) ), "\n";
	exit();
} else {
	echo "client socket create success!\n";
}

//请求连接
$connect_success = @socket_connect( $client_socket, $server_ip, $server_port );
if ( ! $connect_success ) {
	echo "connect server failed,error:  " . socket_strerror( socket_last_error( $client_socket ) ), "\n";
	socket_close( $client_socket );
	exit();
} else {
	echo "connect success!\n";
}

//发送数据/接收数据
$send_str = "hello from client\n";
if ( $connect_success ) {
	$length = socket_write( $client_socket, $send_str, strlen( $send_str ) );
	if ( 0 == $length ) {//写入的长度为0
		echo "write failed";
		socket_close( $client_socket );
		exit();
	}

	$res = socket_read( $client_socket, 1024 );
	echo "response from server,content: " . $res;
}

socket_close( $client_socket );