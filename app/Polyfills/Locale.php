<?php

if (! class_exists('Locale')) {
    final class Locale
    {
        private static string $default = 'en';

        public static function getDefault(): string
        {
            return self::$default;
        }

        public static function setDefault(string $locale): bool
        {
            self::$default = $locale;

            return true;
        }
    }
}
