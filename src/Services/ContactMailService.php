<?php

namespace Darvis\MantaContact\Services;

use Darvis\MantaContact\Models\Contact;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Manta\FluxCMS\Models\Option;
use Manta\FluxCMS\Mail\MailDefault;

class ContactMailService
{
    /**
     * Send contact form email to configured recipients
     *
     * @param Contact $contact
     * @return bool
     */
    public function sendContactEmail(Contact $contact): bool
    {

        try {
            $receivers = $this->getEmailReceivers();
            $subject = $this->getEmailSubject();
            $content = $this->processEmailTemplate($contact);

            Log::info('Contact mail sending to receivers: ' . implode(', ', $receivers));
            foreach ($receivers as $receiver) {
                if ($this->shouldSendToSender($receiver, $contact)) {
                    Log::info('Contact mail sending to sender: ' . $contact->email);
                    Mail::to($contact->email)->send(new MailDefault([
                        'subject' => $subject,
                        'html' => $content,
                        'from' => [
                            'address' => config('manta-contact.email.from.address'),
                            'name' => config('manta-contact.email.from.name'),
                        ],
                        'replyTo' => [
                            'address' => $contact->email,
                            'name' => $contact->name,
                        ],
                    ]));
                } elseif ($this->isValidEmail($receiver)) {
                    Log::info('Contact mail sending to receiver: ' . $receiver);
                    Mail::to($receiver)->send(new MailDefault([
                        'subject' => $subject,
                        'html' => $content,
                        'from' => [
                            'address' => config('manta-contact.email.from.address'),
                            'name' => config('manta-contact.email.from.name'),
                        ],
                        'replyTo' => [
                            'address' => $contact->email,
                            'name' => $contact->name,
                        ],
                    ]));
                } else {
                    Log::info('Invalid email receiver: ' . $receiver);
                }
            }
            return true;
        } catch (\Exception $e) {
            // Log error if needed
            Log::error('Contact mail sending failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get configured email receivers
     *
     * @return array
     */
    private function getEmailReceivers(): array
    {
        $receiversString = Option::get('CONTACT_EMAIL_RECEIVERS', Contact::class, app()->getLocale());
        $receivers = explode(PHP_EOL, $receiversString);

        // Fallback to environment variable if no receivers configured
        if (empty($receivers) || (count($receivers) === 1 && empty($receivers[0]))) {
            $receivers = [env('MAIL_TO_ADDRESS')];
        }

        return array_filter($receivers); // Remove empty entries
    }

    /**
     * Get configured email subject
     *
     * @return string
     */
    private function getEmailSubject(): string
    {
        return Option::get('CONTACT_EMAIL_SUBJECT', Contact::class, app()->getLocale())
            ?? 'Nieuw contactformulier bericht';
    }

    /**
     * Process email template with contact data
     *
     * @param Contact $contact
     * @return string
     */
    private function processEmailTemplate(Contact $contact): string
    {
        $template = Option::get('CONTACT_EMAIL', Contact::class, app()->getLocale());

        if (empty($template)) {
            return $this->getDefaultEmailTemplate($contact);
        }

        // Replace template variables like {{ $contact->name }}
        $pattern = '/\{\{\s*\$(\w+)-&gt;(\w+)\s*\}\}/';

        return preg_replace_callback($pattern, function ($matches) use ($contact) {
            $modelName = $matches[1];   // bijvoorbeeld "contact"
            $attribute = $matches[2];   // bijvoorbeeld "name"

            // Check if the property exists on the contact model
            if ($modelName === 'contact' && isset($contact->{$attribute})) {
                return e($contact->{$attribute});
            }

            return ''; // Fallback for invalid placeholders
        }, $template);
    }

    /**
     * Generate default email template if none configured
     *
     * @param Contact $contact
     * @return string
     */
    private function getDefaultEmailTemplate(Contact $contact): string
    {
        return "
            <h2>Nieuw contactformulier bericht</h2>
            <p><strong>Naam:</strong> {$contact->name}</p>
            <p><strong>Email:</strong> {$contact->email}</p>
            <p><strong>Telefoon:</strong> {$contact->phone}</p>
            <p><strong>Onderwerp:</strong> {$contact->subject}</p>
            <p><strong>Bericht:</strong></p>
            <p>" . nl2br(e($contact->comment)) . "</p>
        ";
    }

    /**
     * Check if email should be sent to the sender
     *
     * @param string $receiver
     * @param Contact $contact
     * @return bool
     */
    private function shouldSendToSender(string $receiver, Contact $contact): bool
    {
        return preg_match('/##ZENDER##/', $receiver) && $this->isValidEmail($contact->email);
    }

    /**
     * Validate email address
     *
     * @param string|null $email
     * @return bool
     */
    private function isValidEmail(?string $email): bool
    {
        return !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}
