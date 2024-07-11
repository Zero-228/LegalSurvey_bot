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

class MainMenu extends InlineMenu
{
    protected Nutgram $bot;

    public function __construct(Nutgram $bot)
    {
        parent::__construct();
        $this->bot = $bot;
    }

    public function start(Nutgram $bot)
    {
        $lang = lang($bot->userId());
        $this->clearButtons()->menuText(msg('welcome_msg', $lang))
            ->addButtonRow(InlineKeyboardButton::make(msg('change_info', $lang), callback_data: '@changeInfo'))
            ->addButtonRow(InlineKeyboardButton::make(msg('new_application', $lang), callback_data: '@makeApplication'))
            ->addButtonRow(InlineKeyboardButton::make(msg('change_language', $lang), callback_data: '@changeLanguage'))
            ->orNext('none')
            ->showMenu();
    }

    protected function changeInfo(Nutgram $bot)
    {
        $this->end();
        $changeInfo = new ChangeUserInfo($bot);
        $changeInfo->start($bot);
        // $lang = lang($bot->userId());
        // $this->clearButtons()->menuText(msg('WIP', lang($bot->userId())))
        //     ->addButtonRow(InlineKeyboardButton::make(msg('back', $lang), callback_data: '@start'))
        //     ->orNext('none')
        //     ->showMenu();
    }

    protected function makeApplication(Nutgram $bot)
    {
        $this->end();
        $createApplication = new CreateApplication($bot);
        $createApplication->start($bot);
        // $lang = lang($bot->userId());
        // $this->clearButtons()->menuText(msg('WIP', lang($bot->userId())))
        //     ->addButtonRow(InlineKeyboardButton::make(msg('back', $lang), callback_data: '@start'))
        //     ->orNext('none')
        //     ->showMenu();
    }

    protected function changeLanguage(Nutgram $bot)
    {
        $this->end();
        $changeLanguage = new LanguageSettings($bot);
        $changeLanguage->start($bot);
    }

    protected function WIP(Nutgram $bot)
    {
        $lang = lang($bot->userId());
        $this->clearButtons()->menuText(msg('WIP', lang($bot->userId())))
            ->addButtonRow(InlineKeyboardButton::make(msg('back', $lang), callback_data: '@start'))
            ->orNext('none')
            ->showMenu();
    }

    public function none(Nutgram $bot)
    {
        $bot->sendMessage('Bye!');
        $this->end();
    }
}
?>
