<?php

namespace App\Http\Controllers;
use App\Models\Card;
use Illuminate\Http\Request;
use App\Models\Transaction;
class TransactionController extends Controller
{


    public function createApi(Request $request)
    {
        $user = auth()->user();
        if($user->role==='admin'){
            $request->validate([
                'amount' => 'required|numeric',
                'sender_card_number' => 'required|exists:cards,NumberCard',
                'receiver_card_number' => 'required|exists:cards,NumberCard',
                'description' => 'required|string|max:255',
                'type' => 'required|in:debit,credit',
            ]);
    
            $transaction = Transaction::create($request->all());
    
            return response()->json(['message' => 'Transaction created successfully', 'transaction' => $transaction], 201);
             }elseif($user->role==='user'){
                 return response()->json(['message' => 'you dont hve rule'], 403);
             }
             else {
                 return response()->json(['message' => 'you no login'], 401);
             }
       
    }

    public function updateApi(Request $request, $id)
    {
        $user = auth()->user();
        if($user->role==='admin'){
            $request->validate([
                'sender_card_number' => 'required|exists:cards,NumberCard',
                'receiver_card_number' => 'required|exists:cards,NumberCard',
                'amount' => 'required|numeric',
                'description' => 'required|string|max:255',
                'type' => 'required|in:debit,credit',
            ]);
    
            $transaction = Transaction::findOrFail($id);
            $transaction->update($request->all());
    
            return response()->json(['message' => 'Transaction updated successfully', 'transaction' => $transaction], 200);
             }elseif($user->role==='user'){
                 return response()->json(['message' => 'you dont hve rule'], 403);
             }
             else {
                 return response()->json(['message' => 'you no login'], 401);
             }

    }

    public function deleteApi($id)
    {
        $user = auth()->user();
        if($user->role==='admin'){
            $transaction = Transaction::findOrFail($id);
            $transaction->delete();
    
            return response()->json(['message' => 'Transaction deleted successfully'], 204);
             }elseif($user->role==='user'){
                 return response()->json(['message' => 'you dont hve rule'], 403);
             }
             else {
                 return response()->json(['message' => 'you no login'], 401);
             }

    }
    
    public function makeTransaction(Request $request)
    {    $user = auth()->user();
        if($user->role==='user'){
            $request->validate([
                'sender_card_number' => 'required|exists:cards,NumberCard',
                'receiver_card_number' => 'required|exists:cards,NumberCard',
                'amount' => 'required|numeric|min:0.01',
                'description' => 'required|string|max:255',
            ]);
            $senderCard = Card::where('NumberCard', $request->input('sender_card_number'))->firstOrFail();
            $receiverCard = Card::where('NumberCard', $request->input('receiver_card_number'))->firstOrFail();
            if ($senderCard->balance < $request->input('amount')) {
                return response()->json(['message' => 'Insufficient funds on the sender\'s card'], 400);
            }
            $senderCard->balance -= $request->input('amount');
            $senderCard->save();
            $receiverCard->balance += $request->input('amount');
            $receiverCard->save();
            $transaction = Transaction::create([
                'sender_card_id' => $senderCard->id,
                'receiver_card_id' => $receiverCard->id,
                'amount' => $request->input('amount'),
                'description' => $request->input('description'),
                'type' => 'debit', 
            ]);
            return response()->json(['message' => 'Transaction completed successfully', 'transaction' => $transaction], 200);
             }elseif($user->role==='admin'){
                 return response()->json(['message' => 'you dont hve rule'], 403);
             }
             else {
                 return response()->json(['message' => 'you no login'], 401);
             }

    }
    public function getTransactionsByCardNumber($card_number)
    {
        $user = auth()->user();
        if($user->role==='user'||$user->role==='admin'){
            $transactions = Transaction::where(function ($query) use ($card_number) {
                $query->where('sender_card_id', '=', $card_number)
                    ->orWhere('receiver_card_id', '=', $card_number);
        })->get();

        return response()->json(['transactions' => $transactions], 200);
        }
        else {
            return response()->json(['message' => 'you no login'], 401);
        }
}

    
}
