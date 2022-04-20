<?php

namespace App\Http\Livewire;

use App\Models\Coupon;

use Livewire\Component;
use Livewire\WithPagination;

class Allcoupons extends Component
{
    use WithPagination;
    protected $listeners = ['destroy'];


    public function render()
    {
        return view('livewire.allcoupons', ['coupons' => Coupon::latest()->paginate(3)]);
    }

    public function confirmDelete($id)
    {
        $this->dispatchBrowserEvent('swal', [
            'title' => 'Are you sure?',
            'text' => "You won't be able to revert this!",
            'icon' => 'warning',
            'showCancelButton' => true,
            'confirmButtonColor' => '#3085d6',
            'cancelButtonColor' => '#d33',
            'confirmButtonText' => 'Yes, delete it!',
            'id' => $id
        ]);
    }

    public function destroy($id)
    {
        $record = Coupon::findOrFail($id);
        if ($record) {
            $record->delete();
            //$this->resetPage();
            $this->render();
        }
    }
}
