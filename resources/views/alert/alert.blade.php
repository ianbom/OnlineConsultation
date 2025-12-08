<!-- Toast Container -->
<div id="toast-container" class="fixed z-50 space-y-2 top-4 right-4"></div>

<!-- Success Toast Template (hidden) -->
<template id="success-toast-template">
    <div
        class="flex items-center p-4 mb-4 text-green-500 transition-all duration-300 ease-in-out transform translate-x-full bg-white border-l-4 border-green-500 rounded-lg shadow-lg opacity-0 toast-item dark:text-green-400 dark:bg-gray-800">
        <div
            class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
            </svg>
        </div>
        <div class="ml-3 text-sm font-normal">
            <span class="font-semibold">Success!</span>
            <span class="toast-message">Operation completed successfully</span>
        </div>
        <button type="button"
            class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
            onclick="closeToast(this)">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
        </button>
    </div>
</template>

<!-- Error Toast Template (hidden) -->
<template id="error-toast-template">
    <div
        class="flex items-center p-4 mb-4 text-red-500 transition-all duration-300 ease-in-out transform translate-x-full bg-white border-l-4 border-red-500 rounded-lg shadow-lg opacity-0 toast-item dark:text-red-400 dark:bg-gray-800">
        <div
            class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
            </svg>
        </div>
        <div class="ml-3 text-sm font-normal">
            <span class="font-semibold">Error!</span>
            <span class="toast-message">Something went wrong</span>
        </div>
        <button type="button"
            class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
            onclick="closeToast(this)">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
        </button>
    </div>
</template>

<!-- Info Toast Template (hidden) -->
<template id="info-toast-template">
    <div
        class="flex items-center p-4 mb-4 text-blue-500 transition-all duration-300 ease-in-out transform translate-x-full bg-white border-l-4 border-blue-500 rounded-lg shadow-lg opacity-0 toast-item dark:text-blue-400 dark:bg-gray-800">
        <div
            class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-blue-500 bg-blue-100 rounded-lg dark:bg-blue-800 dark:text-blue-200">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
        </div>
        <div class="ml-3 text-sm font-normal">
            <span class="font-semibold">Info!</span>
            <span class="toast-message">Information message</span>
        </div>
        <button type="button"
            class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
            onclick="closeToast(this)">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
        </button>
    </div>
</template>

<!-- Laravel Blade Section untuk Session Messages -->
@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            showToast('success', '{{ session('success') }}');
        });
    </script>
@endif

@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            showToast('error', '{{ session('error') }}');
        });
    </script>
@endif

@if (session('info'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            showToast('info', '{{ session('info') }}');
        });
    </script>
@endif

<!-- Demo Buttons -->
{{-- <div class="mb-4 space-x-2">
    <button type="button" class="btn btn-success" onclick="showToast('success', 'Operation completed successfully!')">
        Success Toast
    </button>
    <button type="button" class="btn btn-danger" onclick="showToast('error', 'Something went wrong!')">
        Error Toast
    </button>
    <button type="button" class="btn btn-info" onclick="showToast('info', 'This is an information message!')">
        Info Toast
    </button>
</div> --}}

<!-- JavaScript Functions -->
<script>
    // Function to show toast
    function showToast(type = 'success', message = 'Operation completed successfully', duration = 5000) {
        const container = document.getElementById('toast-container');
        const template = document.getElementById(`${type}-toast-template`);

        if (!template) {
            console.error(`Toast template for type '${type}' not found`);
            return;
        }

        // Clone the template
        const toast = template.content.cloneNode(true);
        const toastElement = toast.querySelector('.toast-item');

        // Set the message
        const messageElement = toast.querySelector('.toast-message');
        messageElement.textContent = message;

        // Add unique ID
        const toastId = 'toast-' + Date.now();
        toastElement.id = toastId;

        // Add to container
        container.appendChild(toast);

        // Get the actual element from DOM
        const addedToast = document.getElementById(toastId);

        // Animate in
        setTimeout(() => {
            addedToast.classList.remove('translate-x-full', 'opacity-0');
            addedToast.classList.add('translate-x-0', 'opacity-100');
        }, 10);

        // Auto remove after duration
        setTimeout(() => {
            closeToast(addedToast.querySelector('button'));
        }, duration);
    }

    // Function to close toast
    function closeToast(button) {
        const toast = button.closest('.toast-item');

        // Animate out
        toast.classList.add('translate-x-full', 'opacity-0');
        toast.classList.remove('translate-x-0', 'opacity-100');

        // Remove from DOM after animation
        setTimeout(() => {
            toast.remove();
        }, 300);
    }

    // Function to close all toasts
    function closeAllToasts() {
        const toasts = document.querySelectorAll('.toast-item');
        toasts.forEach(toast => {
            const button = toast.querySelector('button');
            closeToast(button);
        });
    }

    // Optional: Close toast on click (not just the X button)
    document.addEventListener('click', function(e) {
        if (e.target.closest('.toast-item') && !e.target.closest('button')) {
            const toast = e.target.closest('.toast-item');
            const button = toast.querySelector('button');
            closeToast(button);
        }
    });
</script>

<!-- Optional: Add this CSS for better animations -->
<style>
    .toast-item {
        max-width: 400px;
        min-width: 300px;
    }

    @media (max-width: 640px) {
        .toast-item {
            max-width: calc(100vw - 2rem);
            min-width: calc(100vw - 2rem);
        }

        #toast-container {
            left: 1rem;
            right: 1rem;
            top: 1rem;
        }
    }

    .toast-item:hover {
        transform: translateX(-4px);
    }
</style>
