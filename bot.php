<?php 

/**
 * LegalSurvey Chatbot
 * 
 * Licensed under the Simple Commercial License.
 * 
 * Copyright (c) 2024 Nikita Shkilov nikshkilov@yahoo.com
 * 
 * All rights reserved.
 * 
 * This file is part of PenaltyPuff bot. The use of this file is governed by the
 * terms of the Simple Commercial License, which can be found in the LICENSE file
 * in the root directory of this project.
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once 'config.php';
require_once 'functions.php';
require_once 'localization.php';
foreach (glob("menus/*.php") as $filename)
{
    require $filename;
}

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Configuration;
use SergiX44\Nutgram\Support\DeepLink;
use SergiX44\Nutgram\RunningMode\Webhook;
use SergiX44\Nutgram\Conversations\InlineMenu;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;

$filesystemAdapter = new FilesystemAdapter();
$cache = new Psr16Cache($filesystemAdapter);
global $filesystemAdapter;
$bot = new Nutgram(BOT_TOKEN, new Configuration(cache: $cache));
$bot->setRunningMode(Webhook::class);
$bot->setWebhook(WEBHOOK_URL);

$data = file_get_contents('php://input');
writeLogFile($data, true);

$bot->onCommand('start', function(Nutgram $bot) {
    if (checkUser($bot->userId()) == 'no_such_user') {
        $user_info = get_object_vars($bot->user());
        createUser($user_info);
        createLog(TIME_NOW, 'user', $bot->userId(), 'registering', '/start');
        $bot->sendMessage(msg('pls_change_info', lang($bot->userId())));
        $setInfo = new ChangeUserInfo($bot);
        $setInfo->start($bot);
    } elseif (checkUser($bot->userId()) == 'one_user') {
        createLog(TIME_NOW, 'user', $bot->userId(), 'command', '/start');
        superUpdater('user', 'lastVisit', TIME_NOW, 'userId', $bot->userId(), false);
        $mainMenu = new MainMenu($bot);
        $mainMenu->start($bot);
    } else {
        $bot->sendMessage('WTF are you?');
    }
});

$bot->onCallbackQueryData('deadend', function (Nutgram $bot) {
    sleep(1);
    $bot->answerCallbackQuery();
});

$bot->onMessage(function (Nutgram $bot) {
    createLog(TIME_NOW, 'user', $bot->userId(), 'message', $bot->message()->text);
    superUpdater('user', 'lastVisit', TIME_NOW, 'userId', $bot->userId(), false);
    $msg = "You send: ".$bot->message()->text;
    $bot->sendMessage($msg);
});

$bot->run();

?>
