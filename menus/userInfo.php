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

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../localization.php';
require_once __DIR__ . '/../functions.php';

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Conversations\InlineMenu;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

class ChangeUserInfo extends InlineMenu
{
    protected Nutgram $bot;
    protected ?string $setType = null;

    public function __construct(Nutgram $bot)
    {
        parent::__construct();
        $this->bot = $bot;
    }

    public function start(Nutgram $bot)
    {
        $callback = $bot->callbackQuery()->data;
        $lang = lang($bot->userId());
        if ($this->setType == "" || $this->setType == NULL || $callback == msg('back', $lang)) {
            $this->bot->delete('setType');
        } else {
            $type = $this->setType;
            $this->bot->delete('setType');
            switch ($type) {
                case 'name':
                    $type = "firstName";
                    break;
                case 'surname':
                    $type = "lastName";
                    break;
                default:
                    $type = $type;
                    break;
            }
            //error_log($type);
            //error_log($callback);
            superUpdater('user', $type, $callback, 'userId', $bot->userId(), false);
            sleep(1);
        }
        $variables = getUserInfo($bot->userId());
        $msg = "========================\n\n".msg('userInfo', $lang, $variables)."\n\n========================";
        $this->clearButtons()->menuText($msg)
            ->addButtonRow(InlineKeyboardButton::make(msg('set_name_btn', $lang), callback_data: 'name@setData'))
            ->addButtonRow(InlineKeyboardButton::make(msg('set_surname_btn', $lang), callback_data: 'surname@setData'))
            ->addButtonRow(InlineKeyboardButton::make(msg('set_phone_btn', $lang), callback_data: 'phone@setData'))
            ->addButtonRow(InlineKeyboardButton::make(msg('set_email_btn', $lang), callback_data: 'email@setData'))
            ->addButtonRow(InlineKeyboardButton::make(msg('confirm', $lang), callback_data: '@none'))
            ->orNext('none')
            ->showMenu();
    }

    public function setData(Nutgram $bot)
    {
        $type = $bot->callbackQuery()->data;
        $this->setType = $type;
        $lang = lang($bot->userId());
        $msg = msg('set_pls', $lang).msg($type, $lang);
        $this->clearButtons()->menuText($msg)
            ->addButtonRow(InlineKeyboardButton::make(msg('back', $lang), callback_data: '@start'))
            ->orNext('handleData')
            ->showMenu();
    }

    public function handleData(Nutgram $bot)
    {
        $bot->deleteMessage($bot->userId(), $bot->messageId());
        $data = $bot->message()->text;
        $type = $this->setType;
        $lang = lang($bot->userId());
        $msg = msg('changed_data', $lang, ['{data}' => msg($type, $lang)],).$data;
        $this->clearButtons()->menuText($msg)
            ->addButtonRow(InlineKeyboardButton::make(msg('back', $lang), callback_data: '@start'),InlineKeyboardButton::make(msg('confirm', $lang), callback_data: $data.'@start'))
            ->orNext('handleData')
            ->showMenu();
    }

    public function none(Nutgram $bot)
    {
        $this->end();
        $mainMenu = new MainMenu($bot);
        $mainMenu->start($bot);
    }
}
?>
