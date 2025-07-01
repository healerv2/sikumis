<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\NotificationSetting;
use App\Events\NotificationUpdated;
use App\Notifications\VitaminReminder;
use Carbon\Carbon;

class SendScheduledNotifications extends Command
{
    protected $signature = 'notifikasi:suplement';
    protected $description = 'Kirim notifikasi berdasarkan interval pengingat user';

    public function handle()
    {
        $now = Carbon::now();

        $settings = NotificationSetting::with('user')
            ->where('status', true)
            ->get();

        foreach ($settings as $setting) {
            $user = $setting->user;
            if (!$user || !$user->status_users || $user->level !== 2) continue;

            // Hitung interval dalam menit
            $intervalMinutes = match ($setting->interval) {
                '15_menit' => 15,
                '30_menit' => 30,
                '45_menit' => 45,
                '1_jam'    => 60,
                '2_jam'    => 120,
                '6_jam'    => 360,
                '12_jam'   => 720,
                '1_hari'   => 1440,
                '2_hari'   => 2880,
                'mingguan' => 10080,
                default    => null,
            };

            if (!$intervalMinutes) continue;

            $lastSent = $setting->last_notified_at ?? $setting->created_at;
            $nextSchedule = Carbon::parse($lastSent)->addMinutes($intervalMinutes);

            if ($now->greaterThanOrEqualTo($nextSchedule)) {
                // Kirim notifikasi via Pusher (atau Firebase)
                event(new NotificationUpdated(
                    $user->id,
                    'Pengingat Suplemen',
                    'Hai ' . $user->name . ', sudah waktunya minum suplemenmu!'
                ));

                // $user->notify(new VitaminReminder(
                //     'Waktunya Minum Suplemen',
                //     'Hai ' . $user->name . ', ini pengingat untuk minum suplemenmu sekarang.',
                //     '/mobile/jadwal'
                // ));

                try {
                    $user->notify(new VitaminReminder(
                        'Waktunya Minum Suplemen',
                        'Hai ' . $user->name . ', ini pengingat untuk minum suplemenmu sekarang.',
                        '/mobile/jadwal'
                    ));
                } catch (\Throwable $e) {
                    logger()->error("❌ Gagal kirim notifikasi ke {$user->name}: {$e->getMessage()}");
                }


                // Update waktu terakhir notifikasi dikirim
                $setting->update(['last_notified_at' => $now]);

                $this->info("✅ Notifikasi dikirim ke {$user->name} ({$setting->interval})");
            }
        }

        return Command::SUCCESS;
    }
}
