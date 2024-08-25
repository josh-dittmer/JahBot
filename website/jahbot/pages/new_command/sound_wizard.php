<html>
    <head>
        <link rel="stylesheet" href="../../css/theme.css?<?php echo time(); ?>" />
        <link rel="stylesheet" href="../../css/pages/new_command/theme.css?<?php echo time(); ?>" />
        
        <script type="text/javascript" src="../../js/server.js"></script>
        <script type="text/javascript" src="../../js/error.js"></script>
        
        <script type="text/javascript">
            window.onload = () => {
                document.getElementById('sound-source').addEventListener('change', (event) => {
                    switch(event.target.value) {
                        case 'file':
                            document.getElementById('file-sound').style.display = 'block';
                            document.getElementById('youtube-sound').style.display = 'none';
                            break;
                        case 'youtube':
                            document.getElementById('file-sound').style.display = 'none';
                            document.getElementById('youtube-sound').style.display = 'block';
                            break;
                    }
                });
            };
            
            function createCommandFile() {
                let keyword = document.getElementById('command-keyword').value;
                let file = document.getElementById('command-sound-file').files[0];
                
                if (!keyword || !file) {
                    error('Please make sure all fields are filled in!');
                    return;
                }
                
                if (file.type !== 'audio/wav' && file.type !== 'audio/mpeg') {
                    error('Unsupported sound type! (Must be .wav or .mp3)');
                    return;
                }
                
                let reqData = {
                    type: 'SOUND',
                    keyword: keyword,
                    sound: {
                        type: 'FILE'
                    }
                };
                
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
                })
            }
            
            function createCommandYT() {
                let keyword = document.getElementById('command-keyword').value;
                let link = document.getElementById('command-sound-link').value;
                
                if (!keyword || !link) {
                    error('Please make sure all fields are filled in!');
                    return;
                }
                
                let reqData = {
                    type: 'SOUND',
                    keyword: keyword,
                    sound: {
                        type: 'YOUTUBE',
                        sound: link
                    }
                };
                
                let formData = new FormData();
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
            <h4>Sound Selection</h4>
            <p class="text">Please select a source for your sound.</p>
            <select id="sound-source">
                <option value="default"></option>
                <option value="file">File Upload</option>
                <option value="youtube">YouTube</option>
            </select>
            <br />
            <br />
            <hr />
            <div id="file-sound" style="display:none">
                <h4>Sound Upload</h4>
                <p class="text">Please select the sound your command will play.</p>
                <br />
                <input type="file" id="command-sound-file" />
                <br />
                <br />
                <hr />
                <br />
                <button onclick="createCommandFile()">Create Command</button>
            </div>
            <div id="youtube-sound" style="display:none">
                <h4>Sound Link</h4>
                <p class="text">Please enter the link to the YouTube video your command will play.</p>
                <br />
                <input type="text" id="command-sound-link" placeholder="Enter YouTube link..." />
                <br />
                <br />
                <hr />
                <br />
                <button onclick="createCommandYT()">Create Command</button>
            </div>
        </div>
    </body>
</html>