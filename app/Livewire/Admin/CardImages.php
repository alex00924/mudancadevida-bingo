<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;

class CardImages extends Component
{
    use WithFileUploads;
    public $cardImage;
    public $headerImage;

    public function updated($propertyName) {
        switch($propertyName) {
            case "cardImage":
                $this->cardImage->storeAs('public/imgs/card.jpeg');
                $this->reset();
                // $this->redirect(route('admin.card.imgs'));
                break;
            case "headerImage":
                $this->headerImage->storeAs('public/imgs/header.jpeg');
                $this->reset();
                // $this->redirect(route('admin.card.imgs'));
                break;
        }
    }

    public function render()
    {
        return view('livewire.admin.card-images')->layout('layouts.admin');
    }
}
