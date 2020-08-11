<?php

namespace Modules\Mon\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ThemeVueI18nGenerate extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'theme:vue-i18n {themeName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tạo file ngôn ngữ tro vue-i18n';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $themeName = $this->argument('themeName');
        if ($themeName) {
            //themes/guest/resources/lang
            $langPath = '/themes/' . $themeName . '/lang';
            $jsPath = '/themes/' . $themeName . '/resources/js/lang';
            $jsFile = '/themes/' . $themeName . '/resources/js/vue-i18n-locales.generated.js';
            $configs = array_merge(config('vue-i18n-generator'), compact('langPath', 'jsPath', 'jsFile'));
            \Config::set('vue-i18n-generator', $configs);
            \Artisan::call('vue-i18n:generate');
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['themeName', InputArgument::REQUIRED, 'Tên theme là bắt buộc'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            // ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
