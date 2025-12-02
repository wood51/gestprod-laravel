@php
    $alerts = [
        'success' => [
            'class' => 'alert-success',
            'icon' =>
                '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 stroke-current" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>',
        ],
        'error' => [
            'class' => 'alert-error',
            'icon' =>
                '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 stroke-current" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>',
        ],
        'info' => [
            'class' => 'alert-info',
            'icon' =>
                '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 stroke-current" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01"/></svg>',
        ],
    ];
@endphp

<div class="toast toast-top toast-end z-50 space-y-2 pointer-events-auto">
    @foreach ($alerts as $key => $data)
        @if (session($key))
            <div class="alert {{ $data['class'] }} shadow-lg relative pr-10 gap-3" data-flash>

                {{-- Icône --}}
                {!! $data['icon'] !!}

                {{-- Message --}}
                <span>{{ session($key) }}</span>

                {{-- Bouton X --}}
                <button type="button" class="btn btn-xs btn-circle btn-ghost absolute right-2 top-1/2 -translate-y-1/2"
                    data-flash-close>
                    ✕
                </button>
            </div>
        @endif
    @endforeach
</div>

@if (session()->has('success') || session()->has('error') || session()->has('info'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // auto-dismiss + effacement
            document.querySelectorAll('[data-flash]').forEach((toast, index) => {

                const removeToast = () => {
                    toast.style.transition = 'opacity .3s ease-out, transform .3s ease-out';
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateX(10px)';
                    setTimeout(() => toast.remove(), 300);
                };

                // timeout 3 secondes
                setTimeout(removeToast, 3000 + index * 200);

                // bouton X
                const closeBtn = toast.querySelector('[data-flash-close]');
                if (closeBtn) {
                    closeBtn.addEventListener('click', removeToast);
                }
            });
        });
    </script>
@endif
