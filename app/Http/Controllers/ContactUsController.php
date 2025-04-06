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
        $data = [
            'name' => $request->input('name'),
            'user_message' => $request->input('message'), // Change key name
            'number' => $request->input('contact_number'),
        ];
        try {
            ContactUs::create($request->all());
            Mail::to('hiren.business23@gmail.com')->send(new ContactUsMail($data));
            return back()->with('success', 'Message sent successfully! we will contact you soon');
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
// mukeshrlakhatariya1972@gmail.com