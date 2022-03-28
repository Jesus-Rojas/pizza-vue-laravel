<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmail as SendEmailJob;
use App\Mail\SendEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public static function sendEmail($details)
    {
        /* $details = [
            'title' => 'Gracias por su compra',
            'body' => 'Compraste n pizzas por el valor de $',
            'destinatario' => 'jarojas6524@misena.edu.co',
            'asunto' => 'Pizza - Comprobante de pago',
        ]; */
        // Mail::to($details['destinatario'])->send(new SendEmail($details));
        SendEmailJob::dispatch($details);
        return 'Correo electronico enviado';
    }
}
