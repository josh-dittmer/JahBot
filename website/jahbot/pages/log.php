<html>
    <head>
        <link rel="stylesheet" href="../css/theme.css?<?php echo time(); ?>" />
        <link rel="stylesheet" href="../css/pages/log.css?<?php echo time(); ?>" />
        
        <script type="text/javascript" src="../js/server.js"></script>
        <script type="text/javascript" src="../js/error.js"></script>
        <script type="text/javascript" src="../js/time.js"></script>
        
        <script type="text/javascript">
            const guild = <?php echo (isset($_GET['guild']) ? '\'' . $_GET['guild'] . '\'' : 'null'); ?>;
            
            const log = new Map();
            
            window.onload = () => {
                document.getElementById('server-select').addEventListener('change', (event) => {
                    if (event.target.value === '') return;
                    
                    location = 'log.php?guild=' + event.target.value;
                })
                
                if (guild) {
                    document.getElementById('server-log-container').style.display = 'block';
                    serverRequest('log/' + guild, 'GET', null)
                    .then((data) => {
                        if (data.success !== true) {
                            error('Failed to retrieve log: ' + data.error);
                        } else {
                            let userTable = document.getElementById('user-table');
                            userTable.deleteRow(1);
                            
                            let rowIndex = 0;
                            
                            data.users.forEach((user, index) => {
                                let row = userTable.insertRow(++rowIndex);
                                
                                row.insertCell(0).innerHTML = '<b>#' + (index + 1) + ':</b> ' + user.name;
                                
                                let time = formatTimeDays(user.time);
                                row.insertCell(1).innerHTML = time.days + ' days, ' + time.hours + ' hours, ' + time.minutes + ' minutes, ' + time.seconds + ' seconds';
                                
                                row.insertCell(2).innerHTML = user.lastOnline;
                            });
                        }
                    })
                    .catch((err) => {
                        error('Failed to retrieve log: ' + err); 
                    });
                } else {
                    document.getElementById('server-select-container').style.display = 'block';
                    serverRequest('log', 'GET', null)
                    .then((data) => {
                        if (data.success !== true) {
                            error('Failed to retrieve server list: ' + data.error);
                        } else {
                            let select = document.getElementById('server-select');
                            data.guilds.forEach((guild) => {
                                let opt = document.createElement('option');
                                opt.value = guild.id;
                                opt.innerHTML = guild.name;
                                select.appendChild(opt);
                            });
                        }
                    })
                    .catch((err) => {
                        error('Failed to retrieve server list: ' + err); 
                    });
                }
            };
        </script>
    </head>
    <body>
        <h1>JahBot Log</h1>
        <div id="server-select-container" style="display:none">
            <p class="text">Please select a server.</p>
            <select id="server-select">
                <option value="default"></option>
            </select>
        </div>
        <div id="server-log-container" style="display:none">
            <a class="text button-link" href="log.php">Back</a>
            <br />
            <br />
            <br />
            <table class="text" id="user-table">
                <tr>
                    <th>Username</th>
                    <th>Time Online</th>
                    <th>Last Seen</th>
                </tr>
                <tr>
                    <td>Loading...</td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </div>
    </body>
</html>