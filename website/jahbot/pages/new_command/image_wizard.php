<html>
    <head>
        <link rel="stylesheet" href="../../css/theme.css?<?php echo time(); ?>" />
        <link rel="stylesheet" href="../../css/pages/new_command/theme.css?<?php echo time(); ?>" />
        
        <script type="text/javascript" src="../../js/server.js"></script>
        <script type="text/javascript" src="../../js/error.js"></script>
        
        <script type="text/javascript">
            function createCommand() {
                let keyword = document.getElementById('command-keyword').value;
                let file = document.getElementById('command-image').files[0];
                let text = document.getElementById('command-text').value;
                
                if (!keyword || !file) {
                    error('Please make sure all fields are filled in!');
                    return;
                }
                
                if (file.type !== 'image/png' && file.type !== 'image/jpeg' && file.type !== 'image/gif') {
                    error('Unsupported image type! (Must be .png, .jpg, or .gif)');
                    return;
                }
                
                let reqData = {
                    type: 'IMAGE',
                    keyword: keyword
                };
                
                if (text) reqData.text = text;
                
                let formData = new FormData();
                formData.append('file', file);
                formData.append('commandInfo', JSON.stringify(reqData));
                
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
            <h4>Image Upload</h4>
            <p class="text">Please select the image your command will display.</p>
            <br />
            <input type="file" id="command-image" />
            <br />
            <br />
            <hr />
            <h4>Image Caption (Optional)</h4>
            <p class="text">If you want to display a message with your image, enter it below. If not, leave the textbox empty.</p>
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