<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;
use LivewireUI\Modal\ModalComponent;

class Update extends ModalComponent
{
    use Actions;
    public User $user;
    public ?string $name = null;
    public ?string $number_phone = null;
    public ?string $email = null;
    public ?string $birthday = null;
    public ?bool $status = null;

    public function rules()
    {
        return [

            'user.name' => 'required|min:4|max:150',
            'user.number_phone' => 'nullable|string|min:4|unique:users,number_phone,' . $this->user->id,
            'user.email' => 'required|email|unique:users,email,' . $this->user->id,
            'user.birthday' => 'nullable|date',
            'user.status' => 'required',
    
        ];
    }

    public function __construct()
    {
        $this->user = Auth::user();
    }
    public function render(): View
    {
        return view('livewire.users.update');
    }
    public function update(): void
    {
        

        $this->validate();
        $this->user->save();
        $this->notifications();
        $this->reset();
        $this->emitTo(ListUsers::class, 'users::index::updated');
        $this->closeModal();
        
    }
    public function notifications(){

        $this->notification()->success(
            $title = 'Parabéns!',
            $description =  'Usuário Editado com sucesso!'
        ); 
        foreach(Auth::user()->company->users as $user){
            
            $notification = new \MBarlow\Megaphone\Types\General(
                'Atualização de Usuário!',
                'O usuário(a) '.Auth::user()->name.' editou as informações de um usuário na empresa '.$this->user->company->corporate_reason,
                
            );
            $user->notify($notification);
        }
    }
}
