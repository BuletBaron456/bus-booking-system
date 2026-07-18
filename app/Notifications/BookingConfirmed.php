<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingConfirmed extends Notification
{
    use Queueable;

    public function __construct(public Booking $booking)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $booking = $this->booking->load(['schedule.bus', 'schedule.route']);

        return (new MailMessage)
            ->subject('Your Bus Ticket Reservation is Confirmed')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your bus ticket reservation has been confirmed.')
            ->line('Bus Number: ' . $booking->schedule->bus->bus_number)
            ->line('Route: ' . $booking->schedule->route->origin . ' → ' . $booking->schedule->route->destination)
            ->line('Departure Date: ' . $booking->schedule->departure_date->format('F d, Y'))
            ->line('Seat Number: ' . $booking->seat_number)
            ->action('View Ticket', route('bookings.show', $booking->id))
            ->line('Thank you for booking with us!');
    }

    public function toArray(object $notifiable): array
    {
        $booking = $this->booking->load(['schedule.bus', 'schedule.route']);

        return [
            'booking_id' => $booking->id,
            'message' => 'Your bus ticket reservation has been confirmed.',
            'bus_number' => $booking->schedule->bus->bus_number,
            'route' => $booking->schedule->route->origin . ' → ' . $booking->schedule->route->destination,
            'departure_date' => $booking->schedule->departure_date->format('Y-m-d'),
            'seat_number' => $booking->seat_number,
        ];
    }
}