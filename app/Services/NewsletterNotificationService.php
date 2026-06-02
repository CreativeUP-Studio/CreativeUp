<?php

namespace App\Services;

use App\Models\Lead;
use App\Models\Post;
use App\Models\Service;
use App\Models\Project;
use App\Mail\NewPostNotification;
use App\Mail\NewServiceNotification;
use App\Mail\NewProjectNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NewsletterNotificationService
{
    /**
     * Notify subscribers about a newly published post.
     *
     * @param Post $post
     * @return void
     */
    public static function notifyNewPost(Post $post): void
    {
        $emails = self::getSubscriberEmails();

        if ($emails->isEmpty()) {
            Log::info("NewsletterNotificationService: No hay suscriptores registrados para notificar sobre el post '{$post->title}'.");
            return;
        }

        Log::info("NewsletterNotificationService: Iniciando notificación del post '{$post->title}' a {$emails->count()} suscriptor(es).");

        foreach ($emails as $email) {
            try {
                Mail::to($email)->send(new NewPostNotification($post));
                Log::info("NewsletterNotificationService: Correo enviado a {$email} para el post '{$post->title}'.");
            } catch (\Exception $e) {
                Log::error("NewsletterNotificationService: Error al enviar correo del post '{$post->title}' a {$email}: " . $e->getMessage());
            }
        }
    }

    /**
     * Notify subscribers about a newly activated service.
     *
     * @param Service $service
     * @return void
     */
    public static function notifyNewService(Service $service): void
    {
        $emails = self::getSubscriberEmails();

        if ($emails->isEmpty()) {
            Log::info("NewsletterNotificationService: No hay suscriptores registrados para notificar sobre el servicio '{$service->title}'.");
            return;
        }

        Log::info("NewsletterNotificationService: Iniciando notificación del servicio '{$service->title}' a {$emails->count()} suscriptor(es).");

        foreach ($emails as $email) {
            try {
                Mail::to($email)->send(new NewServiceNotification($service));
                Log::info("NewsletterNotificationService: Correo enviado a {$email} para el servicio '{$service->title}'.");
            } catch (\Exception $e) {
                Log::error("NewsletterNotificationService: Error al enviar correo del servicio '{$service->title}' a {$email}: " . $e->getMessage());
            }
        }
    }

    /**
     * Notify subscribers about a newly published project.
     *
     * @param Project $project
     * @return void
     */
    public static function notifyNewProject(Project $project): void
    {
        $emails = self::getSubscriberEmails();

        if ($emails->isEmpty()) {
            Log::info("NewsletterNotificationService: No hay suscriptores registrados para notificar sobre el proyecto '{$project->title}'.");
            return;
        }

        Log::info("NewsletterNotificationService: Iniciando notificación del proyecto '{$project->title}' a {$emails->count()} suscriptor(es).");

        foreach ($emails as $email) {
            try {
                Mail::to($email)->send(new NewProjectNotification($project));
                Log::info("NewsletterNotificationService: Correo enviado a {$email} para el proyecto '{$project->title}'.");
            } catch (\Exception $e) {
                Log::error("NewsletterNotificationService: Error al enviar correo del proyecto '{$project->title}' a {$email}: " . $e->getMessage());
            }
        }
    }

    /**
     * Get unique emails of active newsletter subscribers.
     *
     * @return \Illuminate\Support\Collection
     */
    protected static function getSubscriberEmails()
    {
        return Lead::where('source', 'newsletter')
            ->whereNotNull('email')
            ->where('email', '!=', '')
            ->distinct()
            ->pluck('email');
    }
}
