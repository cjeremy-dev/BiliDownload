<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Set</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #4A90E2;
        }
        #urls {
            max-width: 600px;
            margin: 0 auto;
            padding: 10px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        a {
            display: block;
            padding: 10px;
            margin: 5px 0;
            background-color: #e7f3fe;
            color: #2175bc;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        a:hover {
            background-color: #d3e6ff;
        }
        br {
            content: "";
            margin: 10px 0;
        }
    </style>
    

</head>
<body>
    <h1>URL Set</h1>
    
        <!-- URLs will be displayed here as links -->
    
    <?php
        session_start(); // 开始session
        
        // 检查session变量是否存在
        if (isset($_SESSION['array1']) && isset($_SESSION['array2'])) {
            $array1 =$_SESSION['array1'];
            $array2 =$_SESSION['array2'];
            echo "<div id='urls'>";
            for ($i = 0; $i < count($array1); $i++) {
                 echo "<a href=$array2[$i]> " . $array1[$i] . "</p>";
            }
            echo "</div>";
            
            // 可以选择在这里删除session变量
            // unset($_SESSION['array1']);
            // unset($_SESSION['array2']);
        } else {
            echo "<p>No data found in session.</p>";
        }
    ?>
</body>
</html>
