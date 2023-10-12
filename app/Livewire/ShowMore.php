<?php

namespace App\Livewire;

use App\Models\Tweet;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * @property-read int $count
 */
class ShowMore extends Component
{
    protected $listeners = ['echo-private:tweets,TweetHasBeenCreated' => '$refresh'];

    public function render(): View
    {
        return view('livewire.show-more');
    }

    public function more(): void
    {
        $this->dispatch( 'show::more')
            ->to(TimeLine::class);

        session()->put('last-tweet', Tweet::query()->latest()->first()->id);
    }

    #[Computed]
    public function count(): int
    {
        return Tweet::query()
            ->where('id', '>', session('last-tweet', 0))
            ->count();
    }
}
