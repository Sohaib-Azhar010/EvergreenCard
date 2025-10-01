<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index()
    {
        $cards = Card::orderBy('created_at', 'desc')->get();
        return view('cards.index', compact('cards'));
    }

    public function create()
    {
        return view('cards.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_number' => 'required|string|max:255',
            'membership_number' => 'required|string|max:255',
            'request_number' => 'required|string|max:255',
            'valid_until' => 'required|date',
            'created_by' => 'required|string|max:255',
        ]);

        Card::create($request->all());

        return redirect()->route('cards.index')
            ->with('success', 'Card created successfully!');
    }
}
