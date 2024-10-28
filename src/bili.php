<?php
// 检查是否是通过POST方法提交的表单
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    // 检查url和quality参数是否存在
    if (isset($_POST['url']) && isset($_POST['quality'])) {
        // 获取url和quality参数的值
        $url =$_POST['url'];
        $quality =$_POST['quality'];
        if($url == '贪吃蛇'){
            header("Location: lol.html");
            exit; 
        }
        if($url == '井字棋'){
            header("Location: fun.html");
            exit; 
        }
        Download($url, $quality);
    } else {
        // 如果参数不存在，则返回错误信息
        echo "请填写所有必填字段。";
    }
} else {
    // 如果不是POST请求，则返回错误信息
    // echo "无效的请求方法。";
    header('Location: error.html');
    exit;
}

function Download($url,$quality)
{
        // 设置Python脚本的路径
    $pythonScriptPath = 'bili.py';
    
    // 构建命令以运行Python脚本并传递参数
    $command = "python3 " . escapeshellarg($pythonScriptPath) . " " . escapeshellarg($url) . " " . escapeshellarg($quality);
    
    if (!function_exists('exec')) {
        echo "The exec() function is disabled on this server.";
        return;
    }
    // 执行命令并捕获输出
    exec($command,$output, $returnVar);
    
    // 检查命令是否成功执行
    if ($returnVar === 0) {
        // 将数组转换为JSON字符串并输出
        
        if ($output){
            
            $a = json_decode(str_replace("'", '"',$output[0]));
            $b = json_decode(str_replace("'", '"',$output[1]));
            // 构建URL，假设URLSet.html位于当前目录
            session_start(); // 开始session
            $_SESSION['array1'] = $a;
            $_SESSION['array2'] = $b;
            // 跳转到新的URL
            header("Location: urlSet.php");
            exit;
        }else{
            
            header("Location: " . "index.html?msg=请输入正确的视频链接");
            exit; 
        }
        
    } else {
        // 如果失败，则输出错误信息
        echo "运行Python脚本时出错，返回码: " . $returnVar;
    }
}






?>


