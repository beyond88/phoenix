<?php

namespace App\Livewire\Media;

use Livewire\Component;

class MediaDetailsModal extends Component
{
    public $selectedItem;

    // Listens for the 'selectedItem' event and calls the 'updateImage' method
    protected $listeners = [
        'selectedItem' => 'updateImage', 
    ];

    // Render the component's view with the selected item
    public function render()
    {
        return view('livewire.media.media-details-modal');
    }

    // Update the selected item with data received from the event
    public function updateImage($data)
    {
        $this->selectedItem = $data;
    }
}
