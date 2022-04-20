<?php

namespace App\Http\Livewire\Admin;



use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Slider as SliderMod;

class Slider extends Component
{
    use WithPagination;
    protected $listeners = ['destroy'];

    public function render()
    {
        return view('livewire.admin.slider', ['sliders' => SliderMod::latest()->paginate(3)]);
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
        $record = SliderMod::findOrFail($id);
        if ($record) {
            unlink($record->slider_img);
            $record->delete();
            //$this->resetPage();
            $this->render();
        }
    }

    public function updateStatus($id)
    {
        $record = SliderMod::findOrFail($id);
        if ($record) {
            $record->update(['status' => $record->status == 1 ? 0 : 1]);
            $this->render();
        }
    }
}
