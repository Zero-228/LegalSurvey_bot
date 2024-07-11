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

class CreateApplication extends InlineMenu
{
    protected Nutgram $bot;
    protected ?int $numFamMembers = null;
    protected ?string $timeInCurrentJob = null;
    protected ?string $companyCountry = null;
    protected ?string $salary = null;
    protected ?string $companyAge = null;
    protected ?string $schengenVisa = null;
    protected ?string $currentLocationSpain = null;
    protected ?string $criminalRecord = null;

    public function __construct(Nutgram $bot)
    {
        parent::__construct();
        $this->bot = $bot;
    }

    public function start(Nutgram $bot)
    {
        $lang = lang($bot->userId());
        $this->clearButtons()->menuText(msg('ap1_quest1', $lang))
            ->addButtonRow(InlineKeyboardButton::make('--------------------------------------', callback_data: '@deadend'))
            ->addButtonRow(InlineKeyboardButton::make('1', callback_data: '1@question2'),InlineKeyboardButton::make('2', callback_data: '2@question2'),InlineKeyboardButton::make('3', callback_data: '3@question2'),InlineKeyboardButton::make('4', callback_data: '4@question2'),InlineKeyboardButton::make('5', callback_data: '5@question2'))
            ->addButtonRow(InlineKeyboardButton::make('6', callback_data: '6@question2'),InlineKeyboardButton::make('7', callback_data: '7@question2'),InlineKeyboardButton::make('8', callback_data: '8@question2'),InlineKeyboardButton::make('9', callback_data: '9@question2'),InlineKeyboardButton::make('10', callback_data: '10@question2'))
            ->addButtonRow(InlineKeyboardButton::make('--------------------------------------', callback_data: '@deadend'))
            ->addButtonRow(InlineKeyboardButton::make(msg('cancel', $lang), callback_data: '@none'))
            ->showMenu();
    }

    protected function question2(Nutgram $bot)
    {
        $lang = lang($bot->userId());
        $numFamMembers = $bot->callbackQuery()->data;
        $this->numFamMembers = $numFamMembers;
        error_log("numFamMembers: ".$this->numFamMembers);

        $this->clearButtons()->menuText(msg('ap1_quest2', $lang))
            ->addButtonRow(InlineKeyboardButton::make('--------------------------------------', callback_data: '@deadend'))
            ->addButtonRow(InlineKeyboardButton::make(msg('ap1_quest2_answ1', $lang), callback_data: '>3@question3'),InlineKeyboardButton::make(msg('ap1_quest2_answ2', $lang), callback_data: '<3@question3'))
            ->addButtonRow(InlineKeyboardButton::make('--------------------------------------', callback_data: '@deadend'))
            ->addButtonRow(InlineKeyboardButton::make(msg('cancel', $lang), callback_data: '@none'),InlineKeyboardButton::make(msg('back', $lang), callback_data: '@start'))
            ->showMenu();
    }

    protected function question3(Nutgram $bot)
    {
        $lang = lang($bot->userId());
        $timeInCurrentJob = $bot->callbackQuery()->data;
        $this->timeInCurrentJob = $timeInCurrentJob;
        error_log("timeInCurrentJob: ".$this->timeInCurrentJob);

        $this->clearButtons()->menuText(msg('ap1_quest3', $lang))
            ->addButtonRow(InlineKeyboardButton::make(msg('cancel', $lang), callback_data: '@none'),InlineKeyboardButton::make(msg('back', $lang), callback_data: '@question2'))
            ->orNext('question4')
            ->showMenu();
    }

    protected function question4(Nutgram $bot)
    {
        $lang = lang($bot->userId());
        $companyCountry = $bot->message()->text;
        $this->companyCountry = $companyCountry;
        error_log("companyCountry: ".$this->companyCountry);

        $bot->deleteMessage($bot->userId(),$bot->messageId());

        $this->clearButtons()->menuText(msg('ap1_quest4', $lang))
            ->addButtonRow(InlineKeyboardButton::make('--------------------------------------', callback_data: '@deadend'))
            ->addButtonRow(InlineKeyboardButton::make(msg('ap1_quest4_answ1', $lang), callback_data: '>year@question5'),InlineKeyboardButton::make(msg('ap1_quest4_answ2', $lang), callback_data: '<year@question5'))
            ->addButtonRow(InlineKeyboardButton::make('--------------------------------------', callback_data: '@deadend'))
            ->addButtonRow(InlineKeyboardButton::make(msg('cancel', $lang), callback_data: '@none'),InlineKeyboardButton::make(msg('back', $lang), callback_data: '@question3'))
            ->showMenu();
    }

    protected function question5(Nutgram $bot)
    {
        $lang = lang($bot->userId());
        $companyAge = $bot->callbackQuery()->data;
        $this->companyAge = $companyAge;
        error_log("companyAge: ".$this->companyAge);

        $this->clearButtons()->menuText(msg('ap1_quest5', $lang))
            ->addButtonRow(InlineKeyboardButton::make(msg('cancel', $lang), callback_data: '@none'),InlineKeyboardButton::make(msg('back', $lang), callback_data: '@question4'))
            ->orNext('question6')
            ->showMenu();
    }

    protected function question6(Nutgram $bot)
    {
        $lang = lang($bot->userId());
        $salary = $bot->message()->text;
        $this->salary = $salary;
        error_log("salary: ".$this->salary);

        $bot->deleteMessage($bot->userId(),$bot->messageId());

        $this->clearButtons()->menuText(msg('ap1_quest6', $lang))
            ->addButtonRow(InlineKeyboardButton::make('--------------------------------------', callback_data: '@deadend'))
            ->addButtonRow(InlineKeyboardButton::make(msg('ap1_answ_yes', $lang), callback_data: 'yes@question7'),InlineKeyboardButton::make(msg('ap1_answ_no', $lang), callback_data: 'no@question7'))
            ->addButtonRow(InlineKeyboardButton::make('--------------------------------------', callback_data: '@deadend'))
            ->addButtonRow(InlineKeyboardButton::make(msg('cancel', $lang), callback_data: '@none'),InlineKeyboardButton::make(msg('back', $lang), callback_data: '@question5'))
            ->showMenu();
    }

    protected function question7(Nutgram $bot)
    {
        $lang = lang($bot->userId());
        $schengenVisa = $bot->callbackQuery()->data;
        $this->schengenVisa = $schengenVisa;
        error_log("schengenVisa: ".$this->schengenVisa);

        $this->clearButtons()->menuText(msg('ap1_quest7', $lang))
            ->addButtonRow(InlineKeyboardButton::make('--------------------------------------', callback_data: '@deadend'))
            ->addButtonRow(InlineKeyboardButton::make(msg('ap1_answ_yes', $lang), callback_data: 'yes@question8'),InlineKeyboardButton::make(msg('ap1_answ_no', $lang), callback_data: 'no@question8'))
            ->addButtonRow(InlineKeyboardButton::make('--------------------------------------', callback_data: '@deadend'))
            ->addButtonRow(InlineKeyboardButton::make(msg('cancel', $lang), callback_data: '@none'),InlineKeyboardButton::make(msg('back', $lang), callback_data: '@question6'))
            ->showMenu();
    }

    protected function question8(Nutgram $bot)
    {
        $lang = lang($bot->userId());
        $currentLocationSpain = $bot->callbackQuery()->data;
        $this->currentLocationSpain = $currentLocationSpain;
        error_log("currentLocationSpain: ".$this->currentLocationSpain);

        $this->clearButtons()->menuText(msg('ap1_quest8', $lang))
            ->addButtonRow(InlineKeyboardButton::make('--------------------------------------', callback_data: '@deadend'))
            ->addButtonRow(InlineKeyboardButton::make(msg('ap1_answ_yes', $lang), callback_data: 'yes@question9'),InlineKeyboardButton::make(msg('ap1_answ_no', $lang), callback_data: 'no@question9'))
            ->addButtonRow(InlineKeyboardButton::make('--------------------------------------', callback_data: '@deadend'))
            ->addButtonRow(InlineKeyboardButton::make(msg('cancel', $lang), callback_data: '@none'),InlineKeyboardButton::make(msg('back', $lang), callback_data: '@question7'))
            ->showMenu();
    }

    protected function question9(Nutgram $bot)
    {
        $lang = lang($bot->userId());
        $criminalRecord = $bot->callbackQuery()->data;
        $this->criminalRecord = $criminalRecord;
        error_log("criminalRecord: ".$this->criminalRecord);

        $this->clearButtons()->menuText(msg('ap1_quest9', $lang))
            ->addButtonRow(InlineKeyboardButton::make(msg('skip', $lang), callback_data: 's@handleApplication'))
            ->addButtonRow(InlineKeyboardButton::make(msg('cancel', $lang), callback_data: '@none'),InlineKeyboardButton::make(msg('back', $lang), callback_data: '@question8'))
            ->orNext('handleApplication')
            ->showMenu();
    }

    protected function handleApplication(Nutgram $bot)
    {
        $lang = lang($bot->userId());
        $ss = $bot->callbackQuery()->data;
        if ($ss != 's') {
            $bot->deleteMessage($bot->userId(),$bot->messageId());
        }
        $this->clearButtons()->menuText(msg('ap1_quest5', $lang))
            ->addButtonRow(InlineKeyboardButton::make(msg('cancel', $lang), callback_data: '@none'),InlineKeyboardButton::make(msg('back', $lang), callback_data: '@question4'))
            ->orNext('question6')
            ->showMenu();
    }

    protected function deadend(Nutgram $bot)
    {
        //
    }

    public function none(Nutgram $bot)
    {
        $this->end();
        $mainMenu = new MainMenu($bot);
        $mainMenu->start($bot);
    }
}
?>
