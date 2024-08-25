<?php
    if (!isset($_GET["page"])) {
        $page = "home.php";
    } else {
        $page = $_GET["page"];
    }
?>

<html>
    <head>
        <title>JahBot</title>
        
        <link rel="stylesheet" href="css/theme.css?<?php echo time(); ?>" />
        <link rel="stylesheet" href="css/index.css?<?php echo time(); ?>" />
        
        <script type="text/javascript">
            window.addEventListener('message', (event) => {
                if (event.data.type === 'error') {
                    document.getElementById('error').style.display = 'block';
                    document.getElementById('error-text').innerHTML = event.data.msg;
                }
            });
            
                            
            function clearError() {
                document.getElementById('error').style.display = 'none';
            }
        </script>
    </head>
    <body>
        <div class="box">
            <div class="box header">
                <h1 class="logo">JahBot</h1>
            </div>
            <div class="box content">
                <div class="sidebar">
                    <div class="item">
                        <img class="item-img" src="img/icons/home.png" />
                        <a class="text item-link" href="index.php?page=home.php">Home</a>
                    </div>
                    <div class="item">
                        <img class="item-img" src="img/icons/commands.png" />
                        <a class="text item-link" href="index.php?page=commands.php">Commands</a>
                    </div>
                    <div class="item">
                        <img class="item-img" src="img/icons/log.png" />
                        <a class="text item-link" href="index.php?page=log.php">Log</a>
                    </div>
                    <div class="item">
                        <img class="item-img" src="img/icons/online_users.png" />
                        <a class="text item-link" href="#" onclick="alert('Coming soon!')">Online Users</a>
                    </div>
                    <div class="item">
                        <img class="item-img" src="img/icons/advanced.png" />
                        <a class="text item-link" href="#" onclick="alert('Coming soon!')">Advanced</a>
                    </div>
                </div>
                <div class="content">
                    <div class="error" id="error" style="display:none">
                        <span class="text error-text" id="error-text">Test Error</span>
                        <a class="text error-dismiss" href="#" onclick="clearError()">Dismiss</a>
                    </div>
                    <iframe class="content-frame" id="content-frame" src=<?php echo '"pages/' . $page . '"'; ?>></iframe>
                </div>
            </div>
            <div class="box footer">
                <span class="text">v2.0.0 | <a href="https://github.com/DisgustingBungHole94/jahbot">GitHub</a></span>
            </div>
        </div>
    </body>
</html>