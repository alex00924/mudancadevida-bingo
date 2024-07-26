<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class SiteSettings extends Component
{
    public $price = 10;
    public $minimumQuantity = 5;
    public $enabledSelling = true;
    public $startSelling = 1;
    public $endSelling = 10000000;

    protected function rules()
    {
        return [
            'price' => ['required', 'numeric', 'gt:0'],
            'minimumQuantity' => ['required', 'numeric', 'gt:0'],
        ];
    }
    public function mount() {
        $this->price = \App\Models\SiteSetting::getPrice();
        $this->minimumQuantity = \App\Models\SiteSetting::getMinimumPurchaseQuantity();
        $this->enabledSelling = \App\Models\SiteSetting::isEnabledSelling();
        $this->startSelling = \App\Models\SiteSetting::getStartSelling();
        $this->endSelling = \App\Models\SiteSetting::getEndSelling();
    }

    public function setPriceValue() {
        $this->validate();
        \App\Models\SiteSetting::setPrice($this->price);
        $this->notify("Preço atualizado");
    }

    public function setMinimumQuantity() {
        $this->validate();
        \App\Models\SiteSetting::setMinimumPurchaseQuantity($this->minimumQuantity);
        $this->notify("Quantidade mínima de compra salva");
    }

    public function setStartEndSelling() {
        $rule = [
            'startSelling' => ['required', 'numeric', 'gt:0'],
            'endSelling' => ['required', 'numeric', "min:$this->startSelling"],
        ];
        $this->validate($rule);
        \App\Models\SiteSetting::setStartSelling($this->startSelling);
        \App\Models\SiteSetting::setEndSelling($this->endSelling);
        $this->notify("Índice de vendas inicial e final economizado");
    }

    public function toggleEnableSelling() {
        $this->enabledSelling = !$this->enabledSelling;
        \App\Models\SiteSetting::setEnableSelling($this->enabledSelling);
    }

    public function render()
    {
        return view('livewire.admin.site-settings')->layout('layouts.admin');
    }
}
