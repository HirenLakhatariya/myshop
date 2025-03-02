<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactUs;
use App\Mail\ContactUsMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact_number' => 'required|string|max:15',
            'message' => 'required|string',
        ]);
        $to = $request->email;
        $subject = 'Contact Us';
        $messageForUser = $request->message;
        $messageForAdmin = $request->message;        
        $contact = ContactUs::create($request->all());
        try {
            Mail::to($to)->send(new ContactUsMail($subject, $messageForUser));
            Mail::to('hirenlakhatariya9@gmail.com')->send(new ContactUsMail($subject, $messageForAdmin));
            return back()->with('success', 'Message sent successfully! we will contact you soon');
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
