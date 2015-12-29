<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <title>登入</title>
    <script type="text/javascript" src="../js/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="stylesheet/style.css">
</head>

<body>
<form action="index.php?login=1"method="post">
    <div>
        <label>用户名:</label>
        <input type="text" name="adminName"placeholder="输入用户名">
        </div>
    <div>
        <label>密码：</label>
        <input type="password"name="password"placeholder="输入密码">

    </div>
    <input type="submit"value="确定">


</form>
</body>
</html>