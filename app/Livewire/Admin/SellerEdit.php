<?php

namespace App\Livewire\Admin;

use LivewireUI\Modal\ModalComponent;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SellerEdit extends ModalComponent
{
    public $userId;
    public $name;
    public $email;
    public $phone;
    public $password;

    public function mount($userId = "") {
        $user = User::find($userId);

        if (!empty($user)) {
            $this->userId = $userId;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->phone = $user->phone;
        }
    }

    public function updateSeller()
    {
        $rule = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class . ',email, ' . $this->userId],
            'phone' => ['required', 'string', 'max:255'],
        ];
        if (!isset($this->userId)) {
            $rule['password'] = ['required'];
        }
        $this->validate($rule);

        $newData = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ];
        if (!empty($this->password)) {
            $newData["password"] = Hash::make($this->password);
        }
        if (empty($this->userId)) {
            $user = User::create($newData);
            $user->assignRole('seller');
            $this->notify('Novo vendedor criado.', 'Sucesso');
        } else {
            $user = User::find($this->userId);
            $user->update($newData);
            $this->notify('Dados do vendedor atualizados.', 'Sucesso');
        }

        $this->dispatch('seller:updated');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.seller-edit');
    }
}
