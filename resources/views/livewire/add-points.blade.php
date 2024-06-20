<div>
    <form wire:submit="create">
        {{ $this->form }}
        
        <button type="submit">
            Add Points
        </button>
    </form>
    
    <x-filament-actions::modals />
</div>
