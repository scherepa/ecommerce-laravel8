<div>
    <form wire:submit.prevent="confirmDelete()">
        @method('delete')
        @csrf
        <button type="submit" class="px-4 rounded-full bg-red-500 text-white js-submit-confirm"><i class="fa fa-trash-o" aria-hidden="true" title="Delete" alt="Delete"></i>
        </button>
    </form>
</div>