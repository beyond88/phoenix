<form class="mb-9">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <div class="row g-3 flex-between-end mb-5">
        <div class="col-auto">
            <h2 class="mb-2">Add New User</h2>
            <h5 class="text-body-tertiary fw-semibold">Create a brand new user and add them to this site.</h5>
        </div>
        <div class="col-auto">
            <a href="{{ url('admin/users') }}" class="btn btn-phoenix-secondary me-2 mb-2 mb-sm-0" type="button">Discard</a>
            <button class="btn btn-primary mb-2 mb-sm-0" type="button" wire:click="">Add New User</button>
        </div>
    </div>

    @if(session()->has('success'))
        <div class="row">
            <div class="col-md-12 col-xl-8">
                <div class="alert alert-outline-success d-flex align-items-center" role="alert">
                    <span class="fas fa-check-circle text-success fs-5 me-3"></span>
                    <p class="mb-0 flex-1">{{ session()->get('success') }}</p>
                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif
    @if(session()->has('error'))
        <div class="row">
            <div class="col-md-12 col-xl-8">
                <div class="alert alert-outline-danger d-flex align-items-center" role="alert">
                    <span class="fas fa-times-circle text-danger fs-5 me-3"></span>
                    <p class="mb-0 flex-1">{{ session()->get('error') }}</p>
                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    <div class="row g-5">
        <div class="col-12 col-xl-8">

            <h4 class="mb-3">Username (required)</h4>
            <input class="form-control mb-5" type="text" wire:model="username"/>

            <h4 class="mb-3">Email (required)</h4>
            <input class="form-control mb-5" type="email" wire:model="email"/>

            <h4 class="mb-3">First Name</h4>
            <input class="form-control mb-5" type="text" wire:model="first_name"/>

            <h4 class="mb-3">Last Name</h4>
            <input class="form-control mb-5" type="text" wire:model="last_name"/>

            <h4 class="mb-3">Website</h4>
            <input class="form-control mb-5" type="text" wire:model="website"/>

            <button class="btn btn-outline-primary me-2 mb-2" type="button">Generate password</button>

            @php
                $initial_password = generate_password( 24 );
            @endphp

            <div class="wp-pwd is-open">
                <div class="password-input-wrapper">
                    <span class="lp-password-input">
                        <input class="form-control strong" 
                            type="password" 
                            id="pass1" 
                            value="{{ $initial_password }}" 
                            data-pw="{{ $initial_password }}" 
                            wire:model="password" />
                        <span class="lp-show-password-input"></span>
                    </span>
                    <div id="pass-strength-result" aria-live="polite" class="strong">Strong</div>
                </div>

                <button type="button" class="btn btn-outline-primary toggle-password" data-toggle="0" aria-label="Hide password">
                    <i class="far fa-eye-slash"></i>
                    <span class="text">Hide</span>
                </button>
            </div>

        </div>

        <div class="col-12 col-xl-4">
            <div class="row g-2">
                <div class="col-12 col-xl-12">
                </div>
            </div>
        </div>
    </div>

<script>
    // document.addEventListener('DOMContentLoaded', function () {
    //     const passwordInput = document.getElementById('pass1');
    //     const toggleButton = document.querySelector('.toggle-password');
    //     const toggleIcon = toggleButton.querySelector('i');
    //     const toggleText = toggleButton.querySelector('.text');
    //     const strengthResult = document.getElementById('pass-strength-result');

    //     passwordInput.value = passwordInput.getAttribute('data-pw');

    //     toggleButton.addEventListener('click', function () {
    //         const isPasswordVisible = passwordInput.type === 'text';
    //         passwordInput.type = isPasswordVisible ? 'password' : 'text';
    //         toggleIcon.classList.toggle('fa-eye');
    //         toggleIcon.classList.toggle('fa-eye-slash');
    //         toggleText.textContent = isPasswordVisible ? 'Show' : 'Hide';
    //     });

    //     passwordInput.addEventListener('keyup', function () {
    //         const password = passwordInput.value;
    //         strengthResult.classList.remove('strong', 'medium', 'weak');
    //         if (password.length > 10) {
    //             strengthResult.textContent = 'Strong';
    //             strengthResult.classList.add('strong');
    //         } else if (password.length > 5) {
    //             strengthResult.textContent = 'Medium';
    //             strengthResult.classList.add('medium');
    //         } else {
    //             strengthResult.textContent = 'Weak';
    //             strengthResult.classList.add('weak');
    //         }
    //     });

    // });

document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const toggleButton = document.querySelector('.wp-hide-pw');
    const strengthMeter = document.getElementById('pass-strength-result');

    // Toggle password visibility
    toggleButton.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        if (type === 'password') {
            this.setAttribute('aria-label', 'Show password');
            this.querySelector('.dashicons').classList.remove('dashicons-hidden');
            this.querySelector('.dashicons').classList.add('dashicons-visibility');
            this.querySelector('.text').textContent = 'Show';
        } else {
            this.setAttribute('aria-label', 'Hide password');
            this.querySelector('.dashicons').classList.remove('dashicons-visibility');
            this.querySelector('.dashicons').classList.add('dashicons-hidden');
            this.querySelector('.text').textContent = 'Hide';
        }
    });

    // Check password strength
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        const result = zxcvbn(password);

        // Update strength meter
        strengthMeter.className = '';
        if (password.length === 0) {
            strengthMeter.textContent = '';
        } else if (result.score < 2) {
            strengthMeter.textContent = 'Weak';
            strengthMeter.classList.add('weak');
        } else if (result.score < 4) {
            strengthMeter.textContent = 'Medium';
            strengthMeter.classList.add('medium');
        } else {
            strengthMeter.textContent = 'Strong';
            strengthMeter.classList.add('strong');
        }
    });
});
</script>
</form>