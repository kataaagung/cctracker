<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;

class PostCrud extends Component
{
    public $posts, $title, $type, $progress, $post_id;
    public $isModalOpen = 0;

    public function render()
    {
        $this->posts = Post::all();
        return view('livewire.post-crud');
    }

    public function create()
    {
        $this->resetCreateForm();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    private function resetCreateForm(){
        $this->title = '';
        $this->type = '';
        $this->progress = '';
    }
    
    public function store()
    {
        $this->validate([
            'title' => 'required',
            'type' => 'required',
            'progress' => 'required',
        ]);
    
        Post::updateOrCreate(['id' => $this->post_id], [
            'title' => $this->title,
            'type' => $this->type,
            'progress' => $this->progress,
        ]);

        session()->flash('message', $this->post_id ? 'Data updated successfully.' : 'Data added successfully.');

        $this->closeModal();
        $this->resetCreateForm();
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $this->post_id = $id;
        $this->title = $post->title;
        $this->type = $post->type;
        $this->typrogresspe = $post->progress;
    
        $this->openModal();
    }
    
    public function delete($id)
    {
        Post::find($id)->delete();
        session()->flash('message', 'Data deleted successfully.');
    }
} 
