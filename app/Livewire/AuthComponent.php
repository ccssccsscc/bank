<?php
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use JWTAuth;

class AuthComponent extends Component
{
    public $FIO;
    public $lizo;
    public $Pincode;
    public $AllBalance;
    public $role;

    public function render()
    {
        return view('livewire.auth-component');
    }

    public function register()
    {
        $validator = Validator::make([
            'FIO' => $this->FIO,
            'lizo' => $this->lizo,
            'Pincode' => $this->Pincode,
            'AllBalance' => $this->AllBalance,
            'role' => $this->role,
        ], [
            'FIO' => 'required',
            'lizo' => 'required|in:fiz,yr',
            'Pincode' => 'required|string|confirmed|min:2',
            'AllBalance' => 'required|integer',
            'role' => 'required|in:admin,user',
        ]);

        if ($validator->fails()) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'Validation failed']);
            return;
        }

        $user = User::create([
            'FIO' => $this->FIO,
            'lizo' => $this->lizo,
            'Pincode' => Hash::make($this->Pincode),
            'AllBalance' => $this->AllBalance,
            'role' => $this->role,
        ]);

        $token = JWTAuth::fromUser($user);

        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'User successfully registered!']);
        // Дополнительные действия, которые вы хотите выполнить после регистрации

        // Очищаем поля формы
        $this->FIO = '';
        $this->lizo = '';
        $this->Pincode = '';
        $this->AllBalance = '';
        $this->role = '';
    }
}