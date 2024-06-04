<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Contracts\DeletesUsers;

class Allusers extends Component
{
    use WithPagination;

    public $modalVisible, $modalDeleteVisible;
    public $modelId, $allUsers, $role, $name;

    /**
     * The validation rules
     *
     * @return void
     */
    public function rules()
    {
        return [
            'role' => 'required',
            'name' => 'required',
        ];
    }

    /**
     * The delete function.
     *
     * @return void
     */
    public function delete()
    {
        $deleter = resolve(DeletesUsers::class);
        $deleter->delete(User::find($this->modelId));

        $this->modalDeleteVisible = false;
        $this->resetPage();
    }

    // MODAL FUNCTIONS ------------------------------------------------

    /**
     * Shows the delete confirmation modal.
     *
     * @param  mixed $id
     * @return void
     */
    public function deleteUserModal($id)
    {
        $this->modelId = $id;
        $this->modalDeleteVisible = true;
        $this->loadModel();
    }

    /**
     * Loads the model data
     * of this component.
     *
     * @return void
     */
    public function loadModel()
    {
        $data = User::find($this->modelId);
        $this->role = $data->role;
        $this->name = $data->name;
    }


    // RENDER ---------------------------------------------------------
    public function render()
    {
        // $this->allUsers = User::paginate(10);
        $this->allUsers = User::where('id', '!=', 1)->paginate(10);


        $links = $this->allUsers;
        $this->allUsers = collect($this->allUsers->items());

        return view('livewire.allusers', ['allUsers' => $this->allUsers, 'links' => $links]);
    }
}
