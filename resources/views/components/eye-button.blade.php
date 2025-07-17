<button type="button" onclick="togglePasswordVisibility('{{ $target }}', this)" tabindex="-1" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 focus:outline-none mt-5">
    <svg class="h-5 w-5 eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
    </svg>
    <svg class="h-5 w-5 eye-closed hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.293-3.95m3.36-2.676A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.973 9.973 0 01-4.043 5.306M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
    </svg>
</button>
<script>
function togglePasswordVisibility(inputId, btn) {
    var input = document.getElementById(inputId);
    if (!input) return;
    var openIcon = btn.querySelector('.eye-open');
    var closedIcon = btn.querySelector('.eye-closed');
    if (input.type === 'password') {
        input.type = 'text';
        openIcon.classList.add('hidden');
        closedIcon.classList.remove('hidden');
    } else {
        input.type = 'password';
        openIcon.classList.remove('hidden');
        closedIcon.classList.add('hidden');
    }
}
</script>
