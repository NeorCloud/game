<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Spatie\Backup\Events\BackupWasSuccessful as BackupWasSuccessfulEvent;
use Spatie\Backup\Notifications\BaseNotification;
use Storage;

class BackupWasSuccessful extends BaseNotification
{

    /** @var BackupWasSuccessfulEvent */
    protected $event;

    public function __construct(BackupWasSuccessfulEvent $event)
    {
        $this->event = $event;
    }

    public function toMail(): MailMessage
    {
        $txt = config('app.name');
        $txt = str_replace(' ', '-', $txt);
        $filesTmp = Storage::files($txt);
        rsort($filesTmp);

        $mailMessage = (new MailMessage)
            ->from(config('backup.notifications.mail.from.address', config('mail.from.address')), config('backup.notifications.mail.from.name', config('mail.from.name')))
            ->subject(trans('backup::notifications.backup_successful_subject', ['application_name' => $this->applicationName()]))
            ->line(trans('backup::notifications.backup_successful_body', ['application_name' => $this->applicationName(), 'disk_name' => $this->diskName()]))
            ->attach(base_path('/storage/app/' . $filesTmp[0]));

        $this->backupDestinationProperties()->each(function ($value, $name) use ($mailMessage) {
            $mailMessage->line("{$name}: $value");
        });
        return $mailMessage;

    }
}
