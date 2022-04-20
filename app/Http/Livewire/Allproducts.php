<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

use App\Models\MultiImg;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;


class Allproducts extends Component
{
    use WithPagination;
    protected $listeners = ['destroy'];

    public function render()
    {
        return view('livewire.allproducts', ['products' => Product::latest()->paginate(3)]);
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
        $record = Product::findOrFail($id);
        if ($record) {
            $images = MultiImg::where('product_id', $id)->get();
            foreach ($images as $img) {
                unlink($img->photo_name);
                MultiImg::where('product_id', $id)->delete();
            }
            unlink($record->product_thumbnail);
            $record->delete();
            //$this->resetPage();
            $this->refresh();
        }
    }

    public function updateStatus($id)
    {
        $record = Product::findOrFail($id);
        if ($record) {
            $record->update(['status' => $record->status == 1 ? 0 : 1]);
            $this->render();
        }
    }
}
