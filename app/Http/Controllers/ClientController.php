<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Contribution;
use App\Models\Card;
use Illuminate\Support\Facades\Auth;
class ClientController extends Controller
{

    
    public function createApi(Request $request)
    {
        $user = auth()->user();
        if($user->role==='admin'){
            $request->validate([
                'FIO' => 'required',
                'lizo' => 'required|in:fiz,yr',
                'CountBrAccount' => 'required|integer',
                'CountCard' => 'required|integer',
                'CountContribution' => 'required|integer',
                'AllBalance' => 'required|integer',
                'PinCode' => 'required|string|max:255',
                'role' => 'string|max:255'
            ]);
    
            $client = Client::create($request->all());
    
            return response()->json(['message' => 'Client created successfully', 'client' => $client], 201);
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
                'FIO' => 'required',
                'lizo' => 'required|in:fiz,yr',
                'CountBrAccount' => 'required|integer',
                'CountCard' => 'required|integer',
                'CountContribution' => 'required|integer',
                'AllBalance' => 'required|integer',
                'PinCode' => 'required|string|max:255',
                'role' => 'string|max:255'
            ]);
    
            $client = Client::findOrFail($id);
            $client->update($request->all());
    
            return response()->json(['message' => 'Client updated successfully', 'client' => $client], 200);
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
            $client = Client::findOrFail($id);
            $client->delete();
    
            return response()->json(['message' => 'Client deleted successfully'], 204);
             }elseif($user->role==='user'){
                 return response()->json(['message' => 'you dont hve rule'], 403);
             }
             else {
                 return response()->json(['message' => 'you no login'], 401);
             }

    }

    public function getClientById($id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        return response()->json(['message' => 'Client found', 'client' => $client], 200);
    }
    public function updateAllBalance($clientId)
    {
        $client = Client::findOrFail($clientId);
        $client->updateAllBalance();

        return response()->json(['message' => 'AllBalance updated successfully', 'client' => $client], 200);
    }
    

}
