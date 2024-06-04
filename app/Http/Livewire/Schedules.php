<?php

namespace App\Http\Livewire;

use App\Models\Media;
use Livewire\Component;
use App\Models\Schedule;
use Livewire\WithPagination;
use Illuminate\Support\Carbon;

class Schedules extends Component
{
    use WithPagination;

    public $content, $mediaOptions, $modelId, $modalSchedule, $modalDeleteSchedule, $selectedClientName;

    public $media_name, $start_time, $end_time, $media_id, $visible = 0;

    // // // listeners watching for schedule updates to refresh visible media


    public function refreshSchedule()
    {
        $this->content = Schedule::all(); // Or fetch updated schedule data as needed

    }

    // --------------------------------------------------------------------

    public function mount()
    {
        // Initialize mediaOptions with initial data
        $this->mediaOptions = Media::select('id', 'client_name')->orderBy('updated_at', 'ASC')->get();
        // Reset selected client name when the component is mounted
        $this->selectedClientName = null;
    }

    public function refreshMediaOptions()
    {
        $this->mediaOptions = Media::select('id', 'client_name')->orderBy('updated_at', 'ASC')->get();
    }


    // Listen for the mediaUpdated event and refresh both media options and schedule content
    protected $listeners = ['mediaUpdated' => 'refreshSchedule', 'optionUpdate' => 'refreshMediaOptions'];

    public function updatedMediaId($value)
    {
        // Find the selected media item
        $selectedMedia = $this->mediaOptions->firstWhere('id', $value);

        // Update the selected client name
        $this->selectedClientName = $selectedMedia ? $selectedMedia->client_name : null;
    }

    // VALIDATION ---------------------------------------------------------

    public function messages(): array
    {
        return [
            'media_id.required' => 'Please select a media item.',
            'start_time.required' => 'Please select a start date.',
            'end_time.required' => 'Please select an end date.',
            'end_time.date' => 'End date cannot occur before the start date.'
        ];
    }

    /**
     * The form validation rules
     *
     * @return void
     */
    protected $rules = [
        'media_id' => 'required',
        'start_time' => 'required',
        'end_time' => 'required |date |after:start_time',
        'visible' => 'nullable'
    ];


    // FUNCTIONS ---------------------------------------------------------

    /**
     * The create function.
     *
     * @return void
     */
    public function create()
    {
        $this->validate();

        $visible = $this->visible == null ? 0 : 1;

        Schedule::create([
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'visible' => $visible,
            'media_id' => $this->media_id

        ]);

        $this->modalSchedule = false;
        $this->cleanVars();

        $this->emit('scheduleUpdated');
    }

    /**
     * File_name updated automatically to the original file image name
     * type_id updated automatically to the file type submitted, based on video or image type
     * @param  mixed $value
     * @return void
     */
    // public function updatedVisible($value)
    // {

    //     if ($value == 1) {
    //         $this->start_time = Carbon::today();
    //     }
    // }


    /**
     * The update function.
     * @return void
     */
    public function update()
    {

        $visible = $this->visible == null ? 0 : 1;
        // locate the media item selected for update
        $item = Schedule::find($this->modelId);
        // update the item
        $item->update([
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'visible' => $visible,
            'media_id' => $this->media_id
        ]);

        $this->modalSchedule = false;
        $this->cleanVars();

        $this->emit('scheduleUpdated');
    }

    /**
     * The delete function.
     * @return void
     */
    public function delete()
    {
        $event = Schedule::find($this->modelId);
        $event->delete();
        $this->modalDeleteSchedule = false;
        $this->resetPage();

        $this->emit('scheduleUpdated');
    }


    // MODAL FUNCTIONS -------------------------------------------------------

    /**
     * Shows the create modal
     * @return void
     */
    public function createSchedule()
    {
        $this->resetValidation();
        $this->cleanVars();
        $this->modalSchedule = true;
    }

    /**
     * Shows the form modal in update mode.
     * @param  mixed $id
     * @return void
     */
    public function updateSchedule($id)
    {
        $this->resetValidation();
        $this->cleanVars();
        $this->modelId = $id;
        $this->modalSchedule = true;
        $this->loadModel();
    }

    /**
     * Shows the delete confirmation modal.
     * @param  mixed $id
     * @return void
     */
    public function deleteSchedule($id)
    {
        $this->modelId = $id;
        $this->modalDeleteSchedule = true;
        $this->loadModel();
    }


    /**
     * Loads the model data of this component.
     * @return void
     */
    public function loadModel()
    {
        $data = Schedule::find($this->modelId);
        $this->media_id = $data->media_id;
        $this->start_time = $data->start_time;
        $this->end_time = $data->end_time;
        $this->visible = $data->visible;
    }

    /**
     * function run to clear the form
     * @return void
     */
    public function cleanVars()
    {
        $this->modelId = null;
        $this->media_id = null;
        $this->start_time = null;
        $this->end_time = null;
        $this->visible = null;
        $this->selectedClientName = null;
    }

    /**
     * On click, close modal and clear the form
     * @return void
     */
    public function close()
    {
        $this->cleanVars();
        $this->modalSchedule = false;
    }

    // RENDER ---------------------------------------------------------
    public function render()
    {
        $today = Carbon::today();
        $mindate = Carbon::today();

        $this->content = Schedule::with('media')->orderBy('start_time', 'asc')->paginate(10);


        $links = $this->content;
        $this->content = collect($this->content->items());

        return view('livewire.schedules', ['content' => $this->content, 'mediaOptions' => $this->mediaOptions, 'today' => $today, 'mindate' => $mindate, 'links' => $links]);
    }
}
