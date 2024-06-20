<x-filament-panels::page>
    <form wire:submit="submit">
        {{ $this->form }}
    
        <br>
        <style>
            .submit-button {
              background-color: #ff9800;
              color: white;
              border: none;
              padding: 10px 15px;
              text-align: center;
              text-decoration: none;
              display: inline-block;
              font-size: 12px;
              font-weight: bold;
              border-radius: 4px;
              cursor: pointer;
              transition: background-color 0.3s;
            }

            .submit-button:hover {
              background-color: #f57c00;
            }
        </style>
        
        <button type="submit" class="submit-button">Add Points to User</button>
    
    </form>
</x-filament-panels::page>

<!-- add x-on:click="document.referrer ? window.history.back() : (window.location.href = 'http:\/\/10.10.21.250:8000\/rewards')" if you want the button to redirect to dashboard -->
