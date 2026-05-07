<?php

namespace App\Providers;

use App\Models\SiteContent;
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
        try {
            $all = SiteContent::pluck('value', 'key')->toArray();

            $emailKeys = ['mail_host', 'mail_port', 'mail_username', 'mail_password', 'mail_encryption', 'mail_from_address', 'mail_from_name'];
            $content   = array_diff_key($all, array_flip($emailKeys));

            if (!empty($all['mail_host'])) {
                config([
                    'mail.default'                 => 'smtp',
                    'mail.mailers.smtp.host'       => $all['mail_host'],
                    'mail.mailers.smtp.port'       => (int) ($all['mail_port'] ?: 587),
                    'mail.mailers.smtp.encryption' => $all['mail_encryption'] ?: 'tls',
                    'mail.mailers.smtp.username'   => $all['mail_username'] ?? null,
                    'mail.mailers.smtp.password'   => $all['mail_password'] ?? null,
                    'mail.from.address'            => $all['mail_from_address'] ?: config('mail.from.address'),
                    'mail.from.name'               => $all['mail_from_name']    ?: config('app.name'),
                ]);
            }
        } catch (\Exception) {
            $content = [];
        }

        view()->share('content', $content);
    }
}
