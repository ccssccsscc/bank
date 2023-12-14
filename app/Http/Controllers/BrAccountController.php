<?php

namespace App\Http\Controllers;
use Illuminate\Support\{
    Facades\Session,
    Str
};
use Illuminate\Http\Request;
use App\Models\BrAccount;
use App\Models\Client;
use Closure;
use Illuminate\Support\Facades\Config;
use JWTAuth;

class BrAccountController extends Controller
{
    
    
    public function createApi(Request $request)
{
    $user = auth()->user();

    if ($user->role === 'user' || $user->role === 'admin') {
        $request->validate([
            'balance' => 'required|numeric',
        ]);
        $accountNumber = strval(rand(100000, 999999));
        $active =true;

        $brAccount = BrAccount::create([
            'client_id' => $user->id,
            'account_number' => $accountNumber,
            'balance' => $request->input('balance'),
            'is_active' => $active,
        ]);
        $BrAccount = Client::where('id', $request->input('client_id'))->firstOrFail();
        $BrAccount->BrAccount += 1;
        $BrAccount->save();

        return response()->json(['message' => 'BrAccount created successfully', 'br_account' => $brAccount], 200);
    } else {
        return response()->json(['message' => 'You are not authorized'], 401);
    }
}
    


    public function updateApi(Request $request, $id)
    {
        $user = auth()->user();

        if ($user->role === 'admin' || $user->role === 'user') {
            $request->validate([
                'account_number' => 'required|string',
                'balance' => 'required|numeric',
                'action' => 'required|in:add,subtract', // Добавляем проверку для действия (add или subtract)
            ]);
    
            $brAccount = BrAccount::where('client_id', $user->id)
                ->where('account_number', $request->input('account_number'))
                ->first();
    
            if (!$brAccount) {
                return response()->json(['message' => 'BrAccount not found'], 404);
            }
    
            // Определяем действие (add или subtract)
            $action = $request->input('action');
            $amount = $request->input('balance');
    
            // Обновляем баланс в зависимости от действия
            if ($action === 'subtract') {
                // Вычитаем из текущего баланса
                $brAccount->balance -= $amount;
            } else {
                // Добавляем к текущему балансу
                $brAccount->balance += $amount;
            }
    
            $brAccount->save();
    
            return response()->json(['message' => 'Balance updated successfully', 'br_account' => $brAccount], 200);
        } else {
            return response()->json(['message' => 'You are not authorized'], 401);
        }
       
    }

    public function deleteApi($id)
    {
        $user = auth()->user();
        if($user->role==='admin'||$user->role==='user'){
             $brAccount = BrAccount::findOrFail($id);
             $brAccount->delete();
             return response()->json(['message' => 'BrAccount deleted successfully'], 204);
        }else {
                 return response()->json(['message' => 'you no login'], 401);
             }

    }

    public function searchById(Request $request, $id){
        $account = BrAccount::find($id);
       $user = auth()->user();
       if($user->role==='admin'){
            if (!$account) {
                return response()->json(['message' => 'Account not found '.$user->role], 404);
            }

            return response()->json(['message' => 'Account found '.$user->role, 'account' => $account], 200);
            }elseif($user->role==='user'){
                return response()->json(['message' => 'you dont hve rule'], 403);
            }
            else {
                return response()->json(['message' => 'you no login'], 401);
            }
    }

    public function createWeb(Request $request)
    {

        // Получение токена из параметров запроса
        $user = auth()->user();
            $request->validate([
                'balance' => 'required|numeric',
            ]);

            $accountNumber = strval(rand(100000, 999999));
            $active = true;

            $brAccount = BrAccount::create([
                'client_id' => $user->id,
                'account_number' => $accountNumber,
                'balance' => $request->input('balance'),
                'is_active' => $active,
            ]);

            // Дополните логику обновления модели Client на основе ваших требований
            $client = Client::findOrFail($user->id);
            $client->BrAccount += 1;
            $client->save();

            return response()->json(['message' => 'BrAccount успешно создан', 'br_account' => $brAccount], 200);
    
        }
    }

    // ... Другие методы ...





