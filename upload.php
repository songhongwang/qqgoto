<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

</head>

<body>
首页轮播
<form id="cake_form" action="/qqgoto/banner" method="post">
    <select onchange="choiceTable(this.value)">
        <option value ="/qqgoto/banner">轮播图banner</option>
        <option value ="/qqgoto/featured">精选</option>
        <option value="/qqgoto/newest">最新</option>
    </select>
    <br><br>

    Name: <input type="text" name="name"><br><br>
    Image: <input type="text" name="img"><br><br>
    Price: <input type="text" name="price"><br><br>
    Des: <input type="text" name="des"><br><br>
    <input type="submit">
</form>

<script language="JavaScript">
    function choiceTable(type) {
        document.getElementById("cake_form").action = type;
    }
    
</script>
</body>
</html>