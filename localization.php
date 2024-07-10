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


$languages = array(
	'en' => array(
		'WIP' => "Development of this feature still in \nprogress.Thank you for your patience. 🧑‍💻",
		'welcome_msg' => "Welcome to main menu",
		'change_language' => '🌐 Change language',
		'choose_language' => 'Choose language',
		'language_changed' => 'Language changed',
		'language' => '🇬🇧 English',
		'cancel' => 'Cancel ❌',
		'canceled' => '❌ Action canceled ',
		'back' => "↩️ Back",
		'confirm' => "Confirm ✅",
		'change_info' => "📃 Change contact info",
		'new_application' => "➕ New application",
		'userInfo' => "|   Name: {name}\n|   Surname: {surname}\n|   Phone: {phone}\n|   Email: {email}",
		'set_name_btn' => "Change name 🔤",
		'set_surname_btn' => "Change surname 🔡",
		'set_phone_btn' => "Change phone 📞",
		'set_email_btn' => "Change email ✉️",
		'set_pls' => "✏️ Please enter your ",
		'name' => "name",
		'surname' => "surname",
		'phone' => "telephone number",
		'email' => "email adress",
		'changed_data' => " ✅ You changed your {data} to:\n",
		'pls_change_info' => "❗️ Please set valid contact info below.",

		/*
		'' => "",
		*/
	),
	'ru' => array(
		'WIP' => "Данная функция находится в процессе \nразработки.Спасибо за ваше терпение. 🧑‍💻",
		'welcome_msg' => 'Добро пожаловать в главное меню',
		'change_language' => '🌐 Сменить язык',
		'choose_language' => 'Выберите язык',
		'language_changed' => 'Язык изменён',
		'language' => '🇷🇺 Русский',
		'cancel' => 'Отменить ❌',
		'canceled' => '❌ Действие отменено ',
		'back' => "↩️ Назад",
		'confirm' => "Confirm ✅",
		'change_info' => "📃 Change contact info",
		'new_application' => "➕ New application",
		'userInfo' => "|   Name: {name}\n|   Surname: {surname}\n|   Phone: {phone}\n|   Email: {email}",
		'set_name_btn' => "Change name 🔤",
		'set_surname_btn' => "Change surname 🔡",
		'set_phone_btn' => "Change phone 📞",
		'set_email_btn' => "Change email ✉️",
		'set_pls' => "✏️ Please enter your ",
		'name' => "name",
		'surname' => "surname",
		'phone' => "telephone number",
		'email' => "email adress",
		'changed_data' => " ✅ You changed your {data} to:\n",
		'pls_change_info' => "❗️ Please set valid contact info below.",
	),
	'uk' => array(
		'WIP' => "Ця функція знаходиться в процессi \nрозробки.Дякую за ваше терпіння. 🧑‍💻",
		'welcome_msg' => 'Ласкаво просимо до головного меню',
		'change_language' => '🌐 Змiнити мову',
		'choose_language' => 'Оберiть мову',
		'language_changed' => 'Мову змiнено',
		'language' => '🇺🇦 Українська',
		'cancel' => 'Вiдмiнити ❌',
		'canceled' => '❌ Дiя вiдмiнена ',
		'back' => "↩️ Назад",
		'confirm' => "Confirm ✅",
		'change_info' => "📃 Change contact info",
		'new_application' => "➕ New application",
		'userInfo' => "|   Name: {name}\n|   Surname: {surname}\n|   Phone: {phone}\n|   Email: {email}",
		'set_name_btn' => "Change name 🔤",
		'set_surname_btn' => "Change surname 🔡",
		'set_phone_btn' => "Change phone 📞",
		'set_email_btn' => "Change email ✉️",
		'set_pls' => "✏️ Please enter your ",
		'name' => "name",
		'surname' => "surname",
		'phone' => "telephone number",
		'email' => "email adress",
		'changed_data' => " ✅ You changed your {data} to:\n",
		'pls_change_info' => "❗️ Please set valid contact info below.",
	),
);

function msg($message_key, $user_language, $variables = []) {
    global $languages;
    
    // 'en' - standart language
    if (!isset($languages[$user_language])) {$user_language = 'en';}

    $message = isset($languages[$user_language][$message_key]) ? $languages[$user_language][$message_key] : "Unknown key";

    // Replacing variables
    if (!empty($variables)) {$message = strtr($message, $variables);}

    return $message;
}

?>