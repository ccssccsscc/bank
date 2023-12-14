<?php

namespace App\Http\Controllers;
use App\Models\Card;
use Illuminate\Http\Request;
use App\Models\Transaction;
class MainController extends Controller
{
    public function BrAcc()
    {
        return view('br_account');
    }
    public function cardpage()
    {
        return view('Card');
    }
    public function contributionpage()
    {
        return view('Contribution');
    }
    public function clientpage()
    {
        return view('Client');
    }
    public function transactionpage()
    {
        return view('transaction');
    }
    public function Homepage()
    {
        return view('home');
    }
}