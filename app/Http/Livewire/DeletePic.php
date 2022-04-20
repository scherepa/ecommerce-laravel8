<?php

namespace App\Http\Livewire;

use App\Models\MultiImg;
use Livewire\Component;

class DeletePic extends Component
{
    public $item, $notification;
    protected $listeners = ['destroy'];


    public function confirmDelete()
    {
        $this->dispatchBrowserEvent('swal', [
            'title' => 'Are you sure?',
            'text' => "You won't be able to revert this!",
            'icon' => 'warning',
            'showCancelButton' => true,
            'confirmButtonColor' => '#3085d6',
            'cancelButtonColor' => '#d33',
            'confirmButtonText' => 'Yes, delete it!',
            'id' => $this->item->id
        ]);
    }

    public function destroy($id)
    {
        $img = MultiImg::findOrFail($id);
        $photo = $img->photo_name;
        //dd($photo);
        $path = '/admin/product/' . $img->product_id . '/edit';
        if ($img) {
            if ($img->photo_name) {
                unlink($img->photo_name);
                $img->delete();
            } else {
                session()->flash('fail', 'smth went wrong');
                return redirect()->to($path);
            }
            $this->notification = "success";
            session()->flash('success', 'Image deleted successfully!');
            return redirect()->to($path);
        }
        session()->flash('fail', 'no such image!');
        return redirect()->to($path);
    }
    public function render()
    {
        return view('livewire.delete-pic');
    }
}
