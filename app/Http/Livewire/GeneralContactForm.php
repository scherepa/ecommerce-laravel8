<?php

namespace App\Http\Livewire;

use App\Models\Contact;
use Livewire\Component;

class GeneralContactForm extends Component
{
    public $theme, $name, $email, $body, $notification;


    public function submit()
    {
        $this->notification = NULL;
        $this->name = trim(strip_tags($this->name));
        $this->theme = trim(strip_tags($this->theme));
        $this->email = trim(strip_tags($this->email));
        $this->body = trim(strip_tags($this->body));
        $data = $this->validate([
            'theme' => 'required|max:255',
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|max:255',
            'body' => 'required|min:2'
        ]);
        Contact::create($data);
        //return redirect()->to('/contact')->with('success', '....');
        $this->reset();
        $this->notification = 'Your message has been sent successfully';
    }



    public function render()
    {
        return view('livewire.general-contact-form');
    }
}
