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

class LanguageSettings extends InlineMenu
{
    protected Nutgram $bot;

    public function __construct(Nutgram $bot)
    {
        parent::__construct();
        $this->bot = $bot;
    }

    public function start(Nutgram $bot)
    {
        $userId = $bot->userId();
        $lang = lang($userId);
        createLog(TIME_NOW, 'user', $userId, 'callback', 'change language');
        $this->clearButtons()->menuText(msg('choose_language', $lang))
            ->addButtonRow(InlineKeyboardButton::make(msg('language', 'en'), callback_data: 'en@handleLang'))
            ->addButtonRow(InlineKeyboardButton::make(msg('language', 'uk'), callback_data: 'uk@handleLang'))
            ->addButtonRow(InlineKeyboardButton::make(msg('language', 'ru'), callback_data: 'ru@handleLang'))
            ->addButtonRow(InlineKeyboardButton::make(msg('cancel', $lang), callback_data: '@none'))
            ->orNext('none')
            ->showMenu();
        superUpdater('user', 'lastVisit', TIME_NOW, 'userId', $bot->userId(), false);
    }

    protected function handleLang(Nutgram $bot)
    {
        $lang = $bot->callbackQuery()->data;
        changeLanguage($bot->userId(), $lang);
        $this->clearButtons()->menuText(msg('language_changed', lang($bot->userId())))
            ->addButtonRow(InlineKeyboardButton::make(msg('back', $lang), callback_data: '@start'), InlineKeyboardButton::make(msg('confirm', $lang), callback_data: '@none'))
            ->orNext('none')
            ->showMenu();
        superUpdater('user', 'lastVisit', TIME_NOW, 'userId', $bot->userId(), false);
    }

    public function none(Nutgram $bot)
    {
        $this->end();
        $mainMenu = new MainMenu($bot);
        $mainMenu->start($bot);
    }
}
?>
