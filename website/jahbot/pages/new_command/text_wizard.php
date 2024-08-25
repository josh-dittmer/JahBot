<html>
    <head>
        <link rel="stylesheet" href="../../css/theme.css?<?php echo time(); ?>" />
        <link rel="stylesheet" href="../../css/pages/new_command/theme.css?<?php echo time(); ?>" />
        
        <script type="text/javascript" src="../../js/server.js"></script>
        <script type="text/javascript" src="../../js/error.js"></script>
        
        <script type="text/javascript">
            function createCommand() {
                let keyword = document.getElementById('command-keyword').value;
                let text = document.getElementById('command-text').value;
                
                if (!keyword || !text) {
                    error('Please make sure all fields are filled in!');
                    return;
                }
                
                let formData = new FormData();
                formData.append('commandInfo', JSON.stringify({
                    type: 'TEXT',
                    keyword: keyword,
                    text: text
                }));
                
                serverRequest('command', 'POST', formData)
                .then((data) => {
                    if (data.success !== true) {
                        error('Failed to create command: ' + data.error);
                    } else {
                        location = '../commands.php';
                    }
                })
                .catch((err) => {
                    error('Failed to create command: ' + err);
                });
            }
        </script>
    </head>
    <body>
        <h1>New Command Wizard</h1>
        <h2>Please enter the information for your command.</h2>
        <br />
        <div class="command-form">
            <h4>Command Keyword</h4>
            <p class="text">Please enter the keyword that will be used to run your command. Do not include semicolons (;;). For example, if you enter "test," typing ";;test" in Discord will run your command.</p>
            <br />
            <input type="text" id="command-keyword" placeholder="Enter keyword..." />
            <br />
            <br />
            <hr />
            <h4>Text to Display</h4>
            <p class="text">Please enter the text your command will display.</p>
            <br />
            <textarea id="command-text" placeholder="Enter text..." rows="7" cols="50"></textarea>
            <br />
            <br />
            <hr />
            <br />
            <button onclick="createCommand()">Create Command</button>
        </div>
    </body>
</html>