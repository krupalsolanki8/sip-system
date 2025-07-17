<p x-show="msg && !(@json($errors->has('password')) || @json($errors->updatePassword->has('password')) || @json($errors->has('user.password')))" class="text-sm text-gray-500 mt-1">
    Note: The password must be 8-16 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character.
</p>