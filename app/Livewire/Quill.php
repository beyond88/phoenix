<?php

namespace App\Livewire;

use Livewire\Component;

class Quill extends Component
{
    const EVENT_VALUE_UPDATED = 'quill_value_updated';
 
    public $value;
    public $quillId;
    public $resetFlag;
 
    public function mount($value = '', $resetFlag = false){
        $this->value = $value;
        $this->quillId = 'quill-'.uniqid();
        $this->resetFlag = $resetFlag;
    }
 
    public function updatedValue($value) {
        $this->dispatch(self::EVENT_VALUE_UPDATED, $this->value);
    }
 
    public function render()
    {
        return view('livewire.quill');
    }

    #[On('reset-quill-editor')]
    public function resetQuillContent() {
        $this->value = ''; // Clear the content in Livewire
        $this->dispatchBrowserEvent('reset-quill-editor', ['quillId' => $this->quillId]);
    }
    
}