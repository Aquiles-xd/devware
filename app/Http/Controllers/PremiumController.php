<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Premium;
use Illuminate\Support\Facades\Auth;


class PremiumController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:premiums,cpf',
        ]);

        $premium = new Premium();
        $premium->user_id = $user->id;
        $premium->name = $request->input('name');
        $premium->cpf = $request->input('cpf');
        $premium->subscribed_at = now();
        $premium->save();

        return response()->json(['message' => 'Premium created successfully', 'premium' => $premium], 201);
    }
}
