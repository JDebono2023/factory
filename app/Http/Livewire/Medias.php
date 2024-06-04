<?php

namespace App\Http\Livewire;

use App\Models\Media;
use Livewire\Component;
use App\Models\Schedule;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class Medias extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $modelId, $media, $file_name, $client_name, $aws_name, $iteration;

    // modal variables
    public $addMediaModal, $deleteMediaModal, $mediaPreviewModal, $showErrorModal;


    // filteriang variables
    public $searchTerm, $mediaScheduled = [], $visibleList = [
        ['type' => "Active", 'schedule' => 1, 'color' => 'text-green-600'], // Active
        ['type' => "Not Active", 'schedule' => 0, 'color' => 'text-red-600'], // Not Active
        ['type' => "Not Scheduled", 'schedule' => 2, 'color' => 'text-gray-600'], // Not Scheduled
    ];

    // reset the pagination after filtering
    public function updatedmediaScheduled()
    {
        $this->resetPage();
    }

    public function updatingsearchTerm()
    {
        $this->resetPage();
    }


    // reset ALL FILTERS on button click
    public function resetFilters()
    {
        $this->reset(['mediaScheduled', 'searchTerm']);
    }

    // listeners watching for schedule updates to refresh visible media
    protected $listeners = ['scheduleUpdated' => 'refreshMedia'];

    public function refreshMedia()
    {
        $this->media = Media::all(); // Or fetch updated media data as needed
    }

    // VALIDATION -------------------------------------------------------------------------
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'file_name.required' => 'An image file is required. Please select an image.',
            'client_name.required' => 'A media name is required. Please provide a name for this image.',
            'client_name.dimensions' => 'Your image exceeds the maximum file dimensions of 543px x 962px.',

        ];
    }

    /**
     * The form validation rules
     *
     * @return void
     */
    protected $rules = [
        'file_name' => 'required',
        'client_name' => 'required',
        'aws_name' => 'image| dimensions:max_width=548,max_height=967'
    ];

    // FUNCTIONS -------------------------------------------------------------------------
    /**
     * The create function.
     *
     * @return void
     */
    public function create()
    {
        $this->validate();

        // hash the media name, and save to AWS
        $name = $this->aws_name->hashName();
        $this->aws_name->storePubliclyAs('factory/images', $name, 's3');


        // create the new media item
        Media::create([
            'file_name' => $this->aws_name->getClientOriginalName(),
            'client_name' => $this->client_name,
            'aws_name' => $name
        ]);

        $this->addMediaModal = false;
        $this->cleanVars();
        $this->emit('mediaUpdated');
        $this->emit('optionUpdate');
    }

    /**
     * File_name updated automatically to the original file image name
     * type_id updated automatically to the file type submitted, based on video or image type
     * @param  mixed $value
     * @return void
     */
    public function updatedawsname($value)
    {
        $this->validate([
            'aws_name' => 'nullable', // 1MB Max
        ]);

        $name = $value->getClientOriginalName();
        $this->file_name = $name;
    }

    /**
     * The update function.
     * @return void
     */
    public function update()
    {
        $this->validate([
            'file_name' => 'required',
            'client_name' => 'required',
            'aws_name' => 'nullable'
        ]);

        // locate the media item selected for update
        $media = Media::find($this->modelId);

        // check the image data, if it's a new updated image, remove the original version tied to the selected ID and add new ones, else save the existing file information with no changes
        if ($this->aws_name != $media->aws_name) {
            Storage::disk('s3')->delete('factory/images/' . $media->aws_name);
            $name = $this->aws_name->getClientOriginalName();
            $data = $this->aws_name->hashName();

            $this->aws_name->storePubliclyAs('factory/images', $data, 's3');
        } else {
            $name = $this->file_name;
            $data = $this->aws_name;
        }

        // update the item
        $media->update([
            'file_name' => $name,
            'client_name' => $this->client_name,
            'aws_name' => $data
        ]);

        $this->addMediaModal = false;
        $this->cleanVars();
        $this->emit('mediaUpdated');
        $this->emit('optionUpdate');
    }

    /**
     * The delete function.
     * @return void
     */
    public function delete()
    {

        $media = media::find($this->modelId);

        // // Check if the media is associated with any events
        // if ($media->schedules()->exists()) {
        //     // If the media has associated schedules, show the error modal
        //     $this->deleteMediaModal = false;
        //     $this->showErrorModal = true;
        //     return;
        // }


        Storage::disk('s3')->delete('factory/images/' . $media->aws_name);

        media::destroy($this->modelId);
        $this->deleteMediaModal = false;
        $this->resetPage();
        $this->emit('mediaUpdated');
        $this->emit('optionUpdate');
    }


    // MODAL FUNCTIONS -------------------------------------------------------------------

    /**
     * On click, close the addMediaModal and clear the form
     * @return void
     */
    public function close()
    {
        $this->cleanVars();
        $this->addMediaModal = false;
    }

    /**
     * Opens addMediaModal
     * @return void
     */
    public function createMediaModal()
    {
        $this->resetValidation();
        $this->cleanVars();
        $this->addMediaModal = true;
    }


    /**
     * Opens updateMediaModal
     * @return void
     */
    public function updateMediaModal($id)
    {
        $this->resetValidation();
        $this->cleanVars();
        $this->modelId = $id;
        $this->addMediaModal = true;
        $this->loadModel();
    }

    /**
     * Opens deleteMediaModal
     * @return void
     */
    public function deleteMediaModal($id)
    {

        $this->modelId = $id;
        $this->loadModel();

        // Check if the media item has associated schedules
        $media = Media::find($this->modelId);
        if ($media && $media->schedules()->exists()) {
            // If associated schedules exist, show the error modal and return
            $this->showErrorModal = true;
            return;
        }

        // If no associated schedules, show the delete modal
        $this->deleteMediaModal = true;
    }

    /**
     * Loads the model data of this component.
     * @return void
     */
    public function loadModel()
    {
        $data = Media::find($this->modelId);
        $this->file_name = $data->file_name;
        $this->client_name = $data->client_name;
        $this->aws_name = $data->aws_name;
    }

    /**
     * function run to clear the form
     * @return void
     */
    public function cleanVars()
    {
        $this->modelId = null;
        $this->iteration++;
        $this->file_name = '';
        $this->client_name = '';
        $this->aws_name = '';
    }

    /**
     * Shows the preview media modal
     * @return void
     */
    public function mediaPreviewModal($id)
    {
        $this->cleanVars();
        $this->modelId = $id;
        $this->mediaPreviewModal = true;
        $this->loadModel();
    }



    // RENDER ------------------------------------------------------------

    public function render()
    {

        $searchTerm = '%' . $this->searchTerm . '%';
        $mediaScheduled = $this->mediaScheduled;

        if ($searchTerm == null && $mediaScheduled == null) {
            $this->media = Media::with('schedules')->orderBy('updated_at', 'asc')->paginate(10);
        } elseif ($searchTerm && !$mediaScheduled) {
            $this->media = Media::with('schedules')->where('client_name', 'like', $searchTerm)->orWhere('file_name', 'like', $searchTerm)->orderBy('updated_at', 'asc')->paginate(10);
        } elseif ($mediaScheduled) {
            // Apply filtering based on mediaScheduled value
            $this->media = Media::when($mediaScheduled !== null, function ($query) use ($mediaScheduled) {
                if ($mediaScheduled === 0) {
                    // Filter for items with a schedule but not visible
                    $query->whereHas('schedules', function ($subquery) {
                        $subquery->where('visible', 0);
                    });
                } else {
                    // Filter based on visible value
                    $query->whereHas('schedules', function ($subquery) use ($mediaScheduled) {
                        $subquery->where('visible', $mediaScheduled);
                    });
                }
            })
                ->orderBy('updated_at', 'asc')
                ->paginate(10);
        }

        $mediaScheduled = isset($mediaScheduled[0]) ? (int)$mediaScheduled[0] : null;

        if ($mediaScheduled === 2) {
            // dd("Inside elseif block");
            $this->media = Media::whereNotIn('id', function ($query) {
                $query->select('media_id')->from('schedules');
            })->orderBy('updated_at', 'asc')
                ->paginate(20);
        }

        $links = $this->media;
        $this->media = collect($this->media->items());


        return view('livewire.medias', ['media' => $this->media, 'visibleList' => $this->visibleList, 'links' => $links]);
    }
}
