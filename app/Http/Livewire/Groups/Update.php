<?php

namespace App\Http\Livewire\Groups;

use App\Models\Group;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class Update extends ModalComponent
{

    public Group $group;

    public ?string $name = null;

    protected $rules = [

        'group.name' => 'required|min:4|max:150'
    ];
    public function __construct()
    {
        $this->group = new Group;
    }
    public function render()
    {
        return view('livewire.groups.update');
    }
    public function update(): void
    {
        $this->validate();
        $this->group->save();
        $this->reset();
        $this->emitTo(ListGroups::class, 'groups::index::updated');
        $this->closeModal();
    }
}