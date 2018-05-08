<?php  
$ws = new swoole_websocket_server("0.0.0.0",9527);  


$ws->on('open', function ($ws, $request) {  
    var_dump($request->fd, $request->get, $request->server);  
    $ws->push($request->fd, '{"data":"服务已经连接"}');  
});    
$ws->on('message', function ($ws, $frame) {    
    echo "<pre>";  
    print_r($frame);
    $data1 = array();
    //print_r($data1);
    foreach($ws->connections as $fd){  
        $ws->push($fd, "{$frame->data}");
        $data1['data'] = $frame->data;
        $data1['uid'] = "客户端编号：".$frame->fd;
        file_put_contents('./log.txt',  join('', $data1)."\r\n",FILE_APPEND);  
    }  
});  

  
$ws->on('close', function ($ws, $fd) {  
    echo "客户端{$fd} 已经关闭\n";  
});  
$ws->start();  
 