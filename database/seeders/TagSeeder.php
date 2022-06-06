<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([ 'name' => 'admin',  'slug' => 'admin',  'title' => 'Admin']);
        DB::table('tags')->insert([ 'name' => 'api',  'slug' => 'api',  'title' => 'API']);
        DB::table('tags')->insert([ 'name' => 'artisan',  'slug' => 'artisan',  'title' => 'Artisan']);
        DB::table('tags')->insert([ 'name' => 'backup',  'slug' => 'backup',  'title' => 'Backup']);
        DB::table('tags')->insert([ 'name' => 'blade',  'slug' => 'blade',  'title' => 'Blade']);
        DB::table('tags')->insert([ 'name' => 'bootstrap',  'slug' => 'bootstrap',  'title' => 'Bootstrap']);
        DB::table('tags')->insert([ 'name' => 'composer',  'slug' => 'composer',  'title' => 'Composer']);
        DB::table('tags')->insert([ 'name' => 'csv',  'slug' => 'csv',  'title' => 'CSV']);
        DB::table('tags')->insert([ 'name' => 'database',  'slug' => 'database',  'title' => 'Database']);
        DB::table('tags')->insert([ 'name' => 'debug',  'slug' => 'debug',  'title' => 'Debug']);
        DB::table('tags')->insert([ 'name' => 'docker',  'slug' => 'docker',  'title' => 'Docker']);
        DB::table('tags')->insert([ 'name' => 'eager loading',  'slug' => 'eager-loading',  'title' => 'Eager loading']);
        DB::table('tags')->insert([ 'name' => 'elasticsearch',  'slug' => 'elasticsearch',  'title' => 'Elasticsearch']);
        DB::table('tags')->insert([ 'name' => 'eloquent',  'slug' => 'eloquent',  'title' => 'Eloquent']);
        DB::table('tags')->insert([ 'name' => 'fortify',  'slug' => 'fortify',  'title' => 'Fortify']);
        DB::table('tags')->insert([ 'name' => 'github',  'slug' => 'github',  'title' => 'Github']);
        DB::table('tags')->insert([ 'name' => 'graphql',  'slug' => 'graphql',  'title' => 'Graphql']);
        DB::table('tags')->insert([ 'name' => 'inertia',  'slug' => 'inertia',  'title' => 'Inertia']);
        DB::table('tags')->insert([ 'name' => 'inertia.js',  'slug' => 'inertia-js',  'title' => 'Inertia.js']);
        DB::table('tags')->insert([ 'name' => 'javascript',  'slug' => 'javascript',  'title' => 'Javascript']);
        DB::table('tags')->insert([ 'name' => 'jetstream',  'slug' => 'jetstream',  'title' => 'Jetstream']);
        DB::table('tags')->insert([ 'name' => 'json',  'slug' => 'json',  'title' => 'JSON']);
        DB::table('tags')->insert([ 'name' => 'laravel',  'slug' => 'laravel',  'title' => 'Laravel']);
        DB::table('tags')->insert([ 'name' => 'livewire',  'slug' => 'livewire',  'title' => 'Livewire']);
        DB::table('tags')->insert([ 'name' => 'lumen',  'slug' => 'lumen',  'title' => 'Lumen']);
        DB::table('tags')->insert([ 'name' => 'markdown',  'slug' => 'markdown',  'title' => 'Markdown']);
        DB::table('tags')->insert([ 'name' => 'mysql',  'slug' => 'mysql',  'title' => 'Mysql']);
        DB::table('tags')->insert([ 'name' => 'notification',  'slug' => 'notification',  'title' => 'Notification']);
        DB::table('tags')->insert([ 'name' => 'php',  'slug' => 'php',  'title' => 'PHP']);
        DB::table('tags')->insert([ 'name' => 'promo',  'slug' => 'promo',  'title' => 'Promo']);
        DB::table('tags')->insert([ 'name' => 'sail',  'slug' => 'sail',  'title' => 'Sail']);
        DB::table('tags')->insert([ 'name' => 'sanctum',  'slug' => 'sanctum',  'title' => 'Sanctum']);
        DB::table('tags')->insert([ 'name' => 'scopes',  'slug' => 'scopes',  'title' => 'Scopes']);
        DB::table('tags')->insert([ 'name' => 'tailwind',  'slug' => 'tailwind',  'title' => 'Tailwind']);
        DB::table('tags')->insert([ 'name' => 'traits',  'slug' => 'traits',  'title' => 'Traits']);
        DB::table('tags')->insert([ 'name' => 'vapor',  'slug' => 'vapor',  'title' => 'Vapor']);
        DB::table('tags')->insert([ 'name' => 'views',  'slug' => 'views',  'title' => 'Views']);
        DB::table('tags')->insert([ 'name' => 'voyager',  'slug' => 'voyager',  'title' => 'Voyager']);
        DB::table('tags')->insert([ 'name' => 'vue',  'slug' => 'vue',  'title' => 'VUE']);
        DB::table('tags')->insert([ 'name' => 'авторизация',  'slug' => 'avtorizatsiya',  'title' => 'Авторизация']);
        DB::table('tags')->insert([ 'name' => 'аутентификация',  'slug' => 'autentifikatsiya',  'title' => 'Аутентификация']);
        DB::table('tags')->insert([ 'name' => 'безопасность',  'slug' => 'bezopasnost',  'title' => 'Безопасность']);
        DB::table('tags')->insert([ 'name' => 'валидация',  'slug' => 'validatsiya',  'title' => 'Валидация']);
        DB::table('tags')->insert([ 'name' => 'даты',  'slug' => 'daty',  'title' => 'Даты']);
        DB::table('tags')->insert([ 'name' => 'идентификация',  'slug' => 'identifikatsiya',  'title' => 'Идентификация']);
        DB::table('tags')->insert([ 'name' => 'изображения',  'slug' => 'izobrazheniya',  'title' => 'Изображения']);
        DB::table('tags')->insert([ 'name' => 'исключения',  'slug' => 'isklyucheniya',  'title' => 'Исключения']);
        DB::table('tags')->insert([ 'name' => 'коллекция',  'slug' => 'kollektsiya',  'title' => 'Коллекция']);
        DB::table('tags')->insert([ 'name' => 'команды',  'slug' => 'komandy',  'title' => 'Команды']);
        DB::table('tags')->insert([ 'name' => 'кэширование',  'slug' => 'keshirovanie',  'title' => 'Кэширование']);
        DB::table('tags')->insert([ 'name' => 'локализация',  'slug' => 'lokalizatsiya',  'title' => 'Локализация']);
        DB::table('tags')->insert([ 'name' => 'маршруты',  'slug' => 'marshruty',  'title' => 'Маршруты']);
        DB::table('tags')->insert([ 'name' => 'миграции',  'slug' => 'migratsii',  'title' => 'Миграции']);
        DB::table('tags')->insert([ 'name' => 'мидлвары',  'slug' => 'midlvary',  'title' => 'Мидлвары']);
        DB::table('tags')->insert([ 'name' => 'модели',  'slug' => 'modeli',  'title' => 'Модели']);
        DB::table('tags')->insert([ 'name' => 'мягкое удаление',  'slug' => 'myagkoe-udalenie',  'title' => 'Мягкое удаление']);
        DB::table('tags')->insert([ 'name' => 'отношения',  'slug' => 'otnosheniya',  'title' => 'Отношения']);
        DB::table('tags')->insert([ 'name' => 'очереди',  'slug' => 'ocheredi',  'title' => 'Очереди']);
        DB::table('tags')->insert([ 'name' => 'ошибки',  'slug' => 'oshibki',  'title' => 'Ошибки']);
        DB::table('tags')->insert([ 'name' => 'пагинация',  'slug' => 'paginatsiya',  'title' => 'Пагинация']);
        DB::table('tags')->insert([ 'name' => 'пакеты',  'slug' => 'pakety',  'title' => 'Пакеты']);
        DB::table('tags')->insert([ 'name' => 'парсинг',  'slug' => 'parsing',  'title' => 'Парсинг']);
        DB::table('tags')->insert([ 'name' => 'паттерны',  'slug' => 'patterny',  'title' => 'Паттерны']);
        DB::table('tags')->insert([ 'name' => 'письма',  'slug' => 'pisma',  'title' => 'Письма']);
        DB::table('tags')->insert([ 'name' => 'платежи',  'slug' => 'platezhi',  'title' => 'Платежи']);
        DB::table('tags')->insert([ 'name' => 'поиск',  'slug' => 'poisk',  'title' => 'Поиск']);
        DB::table('tags')->insert([ 'name' => 'политики',  'slug' => 'politiki',  'title' => 'Политики']);
        DB::table('tags')->insert([ 'name' => 'пользователи',  'slug' => 'polzovateli',  'title' => 'Пользователи']);
        DB::table('tags')->insert([ 'name' => 'провайдеры',  'slug' => 'provaydery',  'title' => 'Провайдеры']);
        DB::table('tags')->insert([ 'name' => 'производительность',  'slug' => 'proizvoditelnost',  'title' => 'Производительность']);
        DB::table('tags')->insert([ 'name' => 'регистрация',  'slug' => 'registratsiya',  'title' => 'Регистрация']);
        DB::table('tags')->insert([ 'name' => 'регулярные выражения',  'slug' => 'regulyarnye-vyrazheniya',  'title' => 'Регулярные выражения']);
        DB::table('tags')->insert([ 'name' => 'редирект',  'slug' => 'redirekt',  'title' => 'Редирект']);
        DB::table('tags')->insert([ 'name' => 'рефакторинг',  'slug' => 'refaktoring',  'title' => 'Рефакторинг']);
        DB::table('tags')->insert([ 'name' => 'секреты',  'slug' => 'sekrety',  'title' => 'Секреты']);
        DB::table('tags')->insert([ 'name' => 'сервисы',  'slug' => 'servisy',  'title' => 'Сервисы']);
        DB::table('tags')->insert([ 'name' => 'сессии',  'slug' => 'sessii',  'title' => 'Сессии']);
        DB::table('tags')->insert([ 'name' => 'слушатели',  'slug' => 'slushateli',  'title' => 'Слушатели']);
        DB::table('tags')->insert([ 'name' => 'события',  'slug' => 'sobytiya',  'title' => 'События']);
        DB::table('tags')->insert([ 'name' => 'советы',  'slug' => 'sovety',  'title' => 'Советы']);
        DB::table('tags')->insert([ 'name' => 'сырые запросы',  'slug' => 'syrye-zaprosy',  'title' => 'Сырые запросы']);
        DB::table('tags')->insert([ 'name' => 'тесты',  'slug' => 'testy',  'title' => 'Тесты']);
        DB::table('tags')->insert([ 'name' => 'файлы',  'slug' => 'fayly',  'title' => 'Файлы']);
        DB::table('tags')->insert([ 'name' => 'фасады',  'slug' => 'fasady',  'title' => 'Фасады']);
        DB::table('tags')->insert([ 'name' => 'фронтенд',  'slug' => 'frontend',  'title' => 'Фронтенд']);
        DB::table('tags')->insert([ 'name' => 'функции',  'slug' => 'funktsii',  'title' => 'Функции']);
        DB::table('tags')->insert([ 'name' => 'хелперы',  'slug' => 'khelpery',  'title' => 'Хелперы']);
        DB::table('tags')->insert([ 'name' => 'чат',  'slug' => 'chat',  'title' => 'Чат']);

    }
}
