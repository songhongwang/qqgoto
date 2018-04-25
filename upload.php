<html>
<body>
首页轮播
<form id="cake_form" action="/banner" method="post">
    <select onchange="choiceTable(this.value)">
        <option value ="banner">轮播图banner</option>
        <option value ="featured">精选</option>
        <option value="newest">最新</option>
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