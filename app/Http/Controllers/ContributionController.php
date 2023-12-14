<?php

namespace App\Http\Controllers;
use App\Models\Contribution;
use Illuminate\Http\Request;
use App\Models\Client;
class ContributionController extends Controller
{

    public function createApi(Request $request)
    {
        $user = auth()->user();
        if($user->role==='admin'||$user->role==='admin'){
            $request->validate([
                'client_id' => 'required|integer',
                'amount' => 'required|numeric',
                'interest_rate' => 'required|numeric',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date',
            ]);
            $CountContribution = Client::where('id', $request->input('client_id'))->firstOrFail();
            $CountContribution->CountContribution += 1;
            $CountContribution->save();
            $contribution = Contribution::create($request->all());
            return response()->json(['message' => 'Contribution created successfully', 'contribution' => $contribution], 201);
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
                'client_id' => 'required|integer',
                'amount' => 'required|numeric',
                'interest_rate' => 'required|numeric',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date',
            ]);
    
            $contribution = Contribution::findOrFail($id);
            $contribution->update($request->all());
    
            return response()->json(['message' => 'Contribution updated successfully', 'contribution' => $contribution], 200);
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
            $contribution = Contribution::findOrFail($id);
            $contribution->delete();
    
            return response()->json(['message' => 'Contribution deleted successfully'], 204);
             }elseif($user->role==='user'){
                 return response()->json(['message' => 'you dont hve rule'], 403);
             }
             else {
                 return response()->json(['message' => 'you no login'], 401);
             }

    }
}
