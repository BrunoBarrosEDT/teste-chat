<?php

namespace App\Http\Livewire\Room;

use App\Models\Room;
use App\Models\User;
use Livewire\Component;

class Chat extends Component
{
    public ?Room $room = null;
    public ?User $withWho = null;

    protected $listeners = [
        'room::chat' => 'selectRoom',
        'message::sent' => '$refresh'
    ];

    public function render()
    {
        return view('livewire.room.chat');
    }

    public function selectRoom($id): void
    {
        $this->room = Room::query()
            ->with('messages')
            ->with('users', fn($b) => $b->where('user_id', '!=', auth()->id()))
            ->where('id', '=', $id)
            ->first();

        $this->withWho = $this->room?->users?->first();
    }
}
