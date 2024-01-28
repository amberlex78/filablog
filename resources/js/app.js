import './bootstrap';

// Import all of Bootstrap's JS
import * as bootstrap from 'bootstrap'

(() => {
    'use strict';

    // Функция для работы с localStorage
    const getStoredValue = (key, defaultValue) => localStorage.getItem(key) || defaultValue;
    const setStoredValue = (key, value) => localStorage.setItem(key, value);

    // Функции для установки фронт-темы и фронт-иконки
    const setFrontTheme = theme => document.documentElement.setAttribute('data-bs-theme', theme);
    const setFrontThemeIcon = themeIcon => document.querySelector('#themeIcon').setAttribute('xlink:href', themeIcon);

    // Установка начальных значений
    setFrontTheme(getStoredValue('theme', 'light'));
    setFrontThemeIcon(getStoredValue('themeIcon', '#icoMoonFill'));

    // Функция для обновления темы и иконки
    const updateTheme = () => {
        const currentTheme = getStoredValue('theme', 'light');
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        setStoredValue('theme', newTheme);
        setFrontTheme(newTheme);

        const currentThemeIcon = getStoredValue('themeIcon', '#icoMoonFill');
        const newThemeIcon = currentThemeIcon === '#icoMoonFill' ? '#icoSunFill' : '#icoMoonFill';
        setStoredValue('themeIcon', newThemeIcon);
        setFrontThemeIcon(newThemeIcon);
    };

    // Добавление обработчика события
    document.querySelector('.change-theme').addEventListener('click', updateTheme);

    // Делаем содержимое видимым
    document.documentElement.classList.remove('hidden-content');

})();
