<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;
use App\Models\Client;
use Closure;
use Illuminate\Support\Facades\Config;
use JWTAuth;
class CardController extends Controller
{
    public function createApi(Request $request)
    {
        $user = auth()->user();

        if ($user->role === 'user' || $user->role === 'admin') {
        $request->validate([
            'NumberCard' => 'required|integer',
            'client_id' => 'required|integer',
            'balance' => 'required|integer',
            'CVV' => 'required|string|max:3',
            'type' => 'required|in:credit,debit',
            'DateFinish' => 'required|string|max:10',
        ]);
        $CountCard = Client::where('id', $request->input('client_id'))->firstOrFail();
        $CountCard->CountCard += 1;
        $CountCard->save();
        $card = Card::create($request->all());

        return response()->json(['message' => 'Card created successfully', 'card' => $card], 201);
    }else {
             return response()->json(['message' => 'you no login'], 401);
         }
        
    }

    public function updateApi(Request $request, $id)
    {
        $user = auth()->user();
        if($user->role==='admin'){
            $request->validate([
                'NumberCard' => 'required|integer',
                'client_id' => 'required|integer',
                'balance' => 'required|integer',
                'CVV' => 'required|string|max:3',
                'type' => 'required|in:credit,debit',
                'DateFinish' => 'required|string|max:10',
            ]);
    
            $card = Card::findOrFail($id);
            $card->update($request->all());
    
            return response()->json(['message' => 'Card updated successfully', 'card' => $card], 200);
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
        if($user->role==='admin'||$user->role==='user'){
            $card = Card::findOrFail($id);
            $card->delete();
    
            return response()->json(['message' => 'Card deleted successfully'], 204);
        }else {
                 return response()->json(['message' => 'you no login'], 401);
             }

    }
    public function getCardById($id)
    {
        $user = auth()->user();
        if($user->role==='admin'){
            $card = Card::find($id);

            if (!$card) {
                return response()->json(['message' => 'Card not found'], 404);
            }
    
            return response()->json(['message' => 'Card found', 'card' => $card], 200);
             }elseif($user->role==='user'){
                 return response()->json(['message' => 'you dont hve rule'], 403);
             }
             else {
                 return response()->json(['message' => 'you no login'], 401);
             }

    }
    
}
