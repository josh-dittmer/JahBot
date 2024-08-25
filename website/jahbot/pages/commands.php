<html>
    <head>
        <link rel="stylesheet" href="../css/theme.css?<?php echo time(); ?>" />
        <link rel="stylesheet" href="../css/pages/commands.css?<?php echo time(); ?>" />
        
        <script type="text/javascript" src="../js/server.js"></script>
        <script type="text/javascript" src="../js/error.js"></script>
        
        <script type="text/javascript">
            window.onload = () => {
                serverRequest('command', 'GET', null)
                .then((data) => {
                    if (data.success !== true) {
                        error('Failed to retrieve commands: ' + data.error);
                        return;
                    }
                    
                    let commandTable = document.getElementById('command-table');
                    commandTable.deleteRow(1);
                    
                    let rowIndex = 0;
                    
                    for(const commandId in data.commands) {
                        let command = data.commands[commandId];
                        
                        let row = commandTable.insertRow(++rowIndex);
                        
                        let cell1 = row.insertCell(0);
                        cell1.innerHTML = command.keyword;
                        
                        let type = command.type;
                        
                        let cell2 = row.insertCell(1);
                        cell2.innerHTML = type;
                        
                        let cell3 = row.insertCell(2);
                        let cell4 = row.insertCell(3);
                        
                        let resourceId = null;
                        
                        switch(type) {
                            case 'SOUND':
                                let sound = command.sound;
                                switch(sound.type) {
                                    case 'FILE':
                                        cell3.innerHTML = '<a target="_blank" href="' + SERVER_ADDRESS + '/resource/' + command.fileId + '">Open Sound</a>';
                                        break;
                                    case 'YOUTUBE':
                                        cell3.innerHTML = '<a target="_blank" href="' + sound.sound + '">Open Sound</a>';
                                        break;
                                }
                                cell4.innerHTML = 'N/A';
                                break;
                            case 'IMAGE':
                                cell3.innerHTML = '<a target="_blank" href="' + SERVER_ADDRESS + '/resource/' + command.fileId + '">Open Image</a>'
                                
                                if (command.text) {
                                    cell4.innerHTML = command.text;
                                } else {
                                    cell4.innerHTML = 'N/A';
                                }
                                break;
                            case 'TEXT':
                                cell3.innerHTML = 'N/A';
                                cell4.innerHTML = command.text;
                                break;
                        }
                        
                        let cell5 = row.insertCell(4);
                        cell5.innerHTML = '<a href="#" onclick="deleteCommand(\'' + commandId + '\')"><img src="../img/icons/delete.png" /></a>';
                    }
                })
                .catch((err) => {
                    error('Failed to retrieve commands: ' + err); 
                });
            };
            
            function deleteCommand(id) {
                if(confirm('Are you sure you want to delete this command? (Cannot be undone)')) {
                    serverRequest('command/' + id, 'DELETE', null)
                    .then((data) => {
                        if (data.success !== true) {
                            error('Failed to delete command: ' + data.error);
                        } else {
                            location.reload();
                        }
                    })
                    .catch((err) => {
                        error(err);
                    })
                }
            }
        </script>
    </head>
    <body>
        <h1>Commands</h1>
        
        <a class="text button-link" href="new_command/wizard.php">+ Create New Command</a>
        
        <br />
        <br />
        <br />
        
        <table class="text" id="command-table">
            <tr>
                <th>Keyword</th>
                <th>Type</th>
                <th>File</th>
                <th>Text</th>
                <th>Actions</th>
            </tr>
            <tr>
                <td>Loading...</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </body>
</html>