const Logger = require('./util/logger.js');
const logger = new Logger('JahBot');

//const Discord = require('discord.js');
const { Client, IntentsBitField } = require('discord.js');
const { token } = require('./resources/config.json');

const TimeLog = require('./log.js');
const SoundPlayer = require('./sound.js');

const FileRegistry = require('./registry/file_registry.js');
const CommandRegistry = require('./registry/command_registry.js');

const Message = require('./util/message.js');

module.exports = class JahBot {
    constructor() {
        this.prefix = ';;';
        
        const intents = new IntentsBitField();
        intents.add(IntentsBitField.Flags.Guilds, IntentsBitField.Flags.GuildMessages, IntentsBitField.Flags.MessageContent, IntentsBitField.Flags.GuildMessageReactions, IntentsBitField.Flags.GuildPresences, IntentsBitField.Flags.GuildMembers, IntentsBitField.Flags.GuildVoiceStates)

        this.client = new Client({ intents: intents });
        
        this.timeLog = new TimeLog();
        this.soundPlayer = new SoundPlayer();
        
        this.fileRegistry = new FileRegistry();
        this.commandRegistry = new CommandRegistry(this.fileRegistry, this.soundPlayer);
    }
    
    start(commandRegistry) {
        this.timeLog.load();
        
        this.fileRegistry.load();
        this.commandRegistry.load();
        
        this.client.login(token);

        this.client.once('ready', () => {
            logger.log('JahBot Discord service has started!');
        });

        this.client.once('reconnecting', () => {
            logger.log('JahBot Discord service is reconnecting!');
        });

        this.client.once('disconnect', () => {
            logger.err('JahBot Discord service has disconnected!');
        });

        this.client.on('voiceStateUpdate', (oldMember, newMember) => {
            let oldChannel = oldMember.channelId;
            let newChannel = newMember.channelId;

            if (oldChannel === null && newChannel !== null) {
                this.timeLog.userJoin(newMember.member);
            } else if (newChannel === null) {
                this.timeLog.userLeave(oldMember.member);
            }
        });
        
        this.client.on('messageCreate', async (message) => {
            if (message.author.bot) return;
            if (!message.content.startsWith(this.prefix)) return;
            
            let rawMsg = message.content.substring(this.prefix.length);
            
            logger.log('User [' + message.author.username + '] invoked "' + message.content + '"!');
            
            if (await this.timeLog.parseInvoke(rawMsg, message)) return;
            if (await this.commandRegistry.parseInvoke(rawMsg, message)) return;
            
            switch(rawMsg) {
                case 'stop':
                    this.soundPlayer.stop(message);
                    break;
                default:
                    Message.send(message.channel, 'Unknown command! Create new commands [here](http://76.236.31.36/suite/apps/jahbot/index.php?page=commands.php)!');
                    break;
            }
                        
            /*const msg = new Message.MultipageMessage({
                title: 'Test Message',
                itemsPerPage: 2,
                displayType: 'titled',
                items: [
                    { title: 'Test1', text: 'Test!' },
                    { title: 'Test2', text: 'Test!' },
                    { title: 'Test3', text: 'Test!' },
                    { title: 'Test4', text: 'Test!' }
                ]
            });
            msg.send(message.channel);*/
        });
    }
}