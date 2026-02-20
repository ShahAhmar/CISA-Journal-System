<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Journal;

class PlagiarismController extends Controller
{
    public function index()
    {
        return view('services.plagiarism');
    }

    public function process(Request $request)
    {
        $request->validate([
            'manuscript' => ['required', 'file', 'mimes:doc,docx,pdf', 'max:10240'],
        ]);

        // In a real scenario, this would integrate with an API like Turnitin or iThenticate.
        // For now, we redirect to payment.

        return redirect()->route('plagiarism.payment');
    }

    public function showPayment()
    {
        return view('services.plagiarism-payment');
    }
}
