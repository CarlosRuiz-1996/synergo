<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserCrud extends Component
    {
        public $users, $name, $email, $password, $user_id;
        public $isOpen = 0;
    
        public function render()
        {
            $this->users = User::all();
            return view('livewire.user-crud');
        }
    
        public function create()
        {
            $this->resetInputFields();
            $this->openModal();
        }
    
        public function openModal()
        {
            $this->isOpen = true;
        }
    
        public function closeModal()
        {
            $this->isOpen = false;
        }
    
        private function resetInputFields()
        {
            $this->name = '';
            $this->email = '';
            $this->password = '';
            $this->user_id = '';
        }
    
        public function store()
        {
            $this->validate([
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);
    
            User::updateOrCreate(['id' => $this->user_id], [
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password)
            ]);
    
            session()->flash('message',
                $this->user_id ? 'Usuario actualizado correctamente.' : 'Usuario creado correctamente.');
    
            $this->closeModal();
            $this->resetInputFields();
        }
    
        public function edit($id)
        {
            $user = User::findOrFail($id);
            $this->user_id = $id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->password = '';
    
            $this->openModal();
        }
    
        public function delete($id)
        {
            User::find($id)->delete();
            session()->flash('message', 'Usuario eliminado correctamente.');
        }
    }
