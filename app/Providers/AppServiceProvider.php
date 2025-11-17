<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useTailwind();

        Carbon::setLocale(config('app.locale'));
        setlocale(LC_TIME, 'id_ID.UTF-8');
        date_default_timezone_set(config('app.timezone'));

        $this->ensurePdfFontDirectories();
    }

    /**
     * DomPDF needs writable directories to store generated font metrics.
     */
    private function ensurePdfFontDirectories(): void
    {
        $paths = array_filter([
            config('dompdf.options.font_dir'),
            config('dompdf.options.font_cache'),
        ]);

        foreach ($paths as $path) {
            if (!is_string($path) || $path === '') {
                continue;
            }

            try {
                File::ensureDirectoryExists($path);
            } catch (\Throwable $e) {
                Log::warning('Failed ensuring DomPDF font directory.', [
                    'path' => $path,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }
}
