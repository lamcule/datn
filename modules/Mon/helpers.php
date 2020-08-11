<?php
require(__DIR__."/composers.php");
if (!function_exists('locales')) {
    /**
     * All active locales
     *
     * @return mixed
     */
    function locales()
    {
        return config('mon.locales');
    }
}


if (!function_exists('locale_prefix')) {
    function locale_prefix()
    {
        $locale = \Request::segment(1);
        return (config('mon.multiple_languages') && in_array($locale, locales()) && $locale != config('app.default_locale')) ? $locale : null;
    }
}

if (!function_exists('clean_html')) {
    /**
     * Clean the html tags
     *
     * @param $content
     * @return string
     */
    function clean_html($content)
    {
        return trim(html_entity_decode(strip_tags(preg_replace('#(?:<br\s*/?>\s*?){2,}#', ' ', nl2br($content)))));
    }
}

if (!function_exists('append_params_to_current_url')) {
    /**
     * Append the params to current url
     *
     * @param $params
     * @return string
     */
    function append_params_to_current_url($params)
    {
        //Retrieve current query strings:
        $currentQueries = \Request::query();

        //Merge together current and new query strings:
        $allQueries = array_merge($currentQueries, $params);

        //Generate the URL with all the queries:
        return \Request::fullUrlWithQuery($allQueries);
    }
}

if (!function_exists('supported_locales')) {
    function supported_locales()
    {
        $locales = locales();

        $supportLocales = [];
        foreach ($locales as $locale) {

            if ($localeData = config('locales.' . $locale)) {
                $supportLocales[$locale] = $localeData;
            }
        }
        return $supportLocales;
    }
}

if (!function_exists('current_locale')) {
    function current_locale()
    {
        return app()->getLocale();
    }
}
