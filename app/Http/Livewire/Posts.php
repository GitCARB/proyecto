<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Post;

class Posts extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $name, $category_id, $description, $state;

    public function render()
    {
		$keyWord = '%'.$this->keyWord .'%';
        return view('livewire.posts.view', [
            'posts' => Post::latest()
						->orWhere('name', 'LIKE', $keyWord)
						->orWhere('category_id', 'LIKE', $keyWord)
						->orWhere('description', 'LIKE', $keyWord)
						->orWhere('state', 'LIKE', $keyWord)
						->paginate(10),
        ]);
    }
	
    public function cancel()
    {
        $this->resetInput();
    }
	
    private function resetInput()
    {		
		$this->name = null;
		$this->category_id = null;
		$this->description = null;
		$this->state = null;
    }

    public function store()
    {
        $this->validate([
		'state' => 'required',
        ]);

        Post::create([ 
			'name' => $this-> name,
			'category_id' => $this-> category_id,
			'description' => $this-> description,
			'state' => $this-> state
        ]);
        
        $this->resetInput();
		$this->dispatchBrowserEvent('closeModal');
		session()->flash('message', 'Post Successfully created.');
    }

    public function edit($id)
    {
        $record = Post::findOrFail($id);
        $this->selected_id = $id; 
		$this->name = $record-> name;
		$this->category_id = $record-> category_id;
		$this->description = $record-> description;
		$this->state = $record-> state;
    }

    public function update()
    {
        $this->validate([
		'state' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Post::find($this->selected_id);
            $record->update([ 
			'name' => $this-> name,
			'category_id' => $this-> category_id,
			'description' => $this-> description,
			'state' => $this-> state
            ]);

            $this->resetInput();
            $this->dispatchBrowserEvent('closeModal');
			session()->flash('message', 'Post Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            Post::where('id', $id)->delete();
        }
    }
}