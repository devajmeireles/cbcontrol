<?php

namespace App\Http\Livewire\Groups;

use App\Http\Livewire\TesteGroup;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
class Create extends ModalComponent
{
    public User $user;
    public ?string $name = null;
    
    protected $rules = [

        'name' => 'required|min:4|max:150'
    ];

    public function __construct()
    {
        $this->user = Auth::user();
    }
    public function render(): View
    {
        return view('livewire.groups.create');
    }
    public function create(): void
    {
        $validated = $this->validate();
        $this->user->company->groups()->updateOrCreate($validated,$validated);
        $this->reset();
        $this->emitTo(ListGroups::class, 'groups::index::created');
        $this->closeModal();
    }
    
}
