<?php

namespace App\Translation;

use Illuminate\Support\Arr;
use Illuminate\Translation\Translator as BaseTranslator;

class Translator extends BaseTranslator
{
    /**
     * @param $key
     * @param array $replace
     * @param $locale
     * @param $fallback
     *
     * @return array|string|null
     */
    public function get($key, array $replace = [], $locale = null, $fallback = true)
    {
        $results = parent::get($key, $replace, $locale, $fallback);

        // If the key does not contain nested translation
        // or the result did not return the key back, then translation was found
        if (!str_contains($key, '.') || $results !== $key) {
            // If the result is an array, then the key pointed to a group of translations
            if (is_array($results)) {
                return $key;
            }

            return $results;
        }

        $locale = $locale ?: $this->locale;
        // Load the translation with dot notation
        $line = Arr::get($this->loaded['*']['*'][$locale], $key);

        // Handle fallback to default language
        if (!isset($line) && $fallback && !empty($this->getFallback()) && $locale !== $this->getFallback()) {
            $this->load('*', '*', $this->getFallback());
            $line = Arr::get($this->loaded['*']['*'][$this->getFallback()], $key);
        }

        return $this->makeReplacements($line ?: $key, $replace);
    }
}
