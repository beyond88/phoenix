<form class="mb-9">
    <div class="row g-3 flex-between-end mb-5">
        <div class="col-auto">
            <h2 class="mb-2">Add New User</h2>
            <h5 class="text-body-tertiary fw-semibold">Create a brand new user and add them to this site.</h5>
        </div>
        <div class="col-auto">
            <a href="{{ url('admin/users') }}" class="btn btn-phoenix-secondary me-2 mb-2 mb-sm-0" type="button">Discard</a>
            <button class="btn btn-primary mb-2 mb-sm-0" id="createnewuser" type="button" wire:click="registerNewUser">Add New User</button>
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
            <input class="form-control mb-5" type="text" id="userLogin" wire:model="userLogin"/>

            <h4 class="mb-3">Email (required)</h4>
            <input class="form-control mb-5" type="email" id="userEmail" wire:model="userEmail"/>

            <h4 class="mb-3">First Name</h4>
            <input class="form-control mb-5" type="text" id="firstName" wire:model="firstName"/>

            <h4 class="mb-3">Last Name</h4>
            <input class="form-control mb-5" type="text" id="lastName" wire:model="lastName"/>

            <h4 class="mb-3">Website</h4>
            <input class="form-control mb-5" type="text" id="userURL" wire:model="userURL"/>

            <div class="user-pass1-wrap">
                <button class="btn btn-outline-primary me-2 mb-2 wp-generate-pw hide-if-no-js" type="button">Generate password</button>

                @php
                    $initial_password = generate_password( 24 );
                @endphp
                <div class="wp-pwd is-open">
                    <div class="password-input-wrapper" style="width: 85%;">
                        <span class="lp-password-input">
                            <input class="form-control" 
                                type="text" 
                                id="pass1"
                                name="userPass"
                                data-pw=""
                                value=""
                                wire:model="userPass" 
                            />
                            <span class="lp-show-password-input"></span>
                        </span>
                    </div>

                    <button type="button" class="btn btn-outline-primary button wp-hide-pw hide-if-no-js" data-toggle="0" aria-label="Hide password">
                        <span class="eye-icon">
                            <i class="far fa-eye-slash"></i>
                        </span>
                        <span class="text">Hide</span>
                    </button>
                </div>
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
        window.wp = window.wp || {};

        let updateLock = false,
        isSubmitting = false,
        pass1Row,
        userPass,
        weakCheckbox,
        toggleButton,
        submitButtons,
        submitButton,
        currentPass,
        form,
        originalFormContent,
        passwordWrapper;

        function generatePassword() {
            if (typeof zxcvbn !== 'function') {
                setTimeout(generatePassword, 50);
                return;
            } else if (!userPass.value || passwordWrapper.classList.contains('is-open')) {
                userPass.value = userPass.dataset.pw;
                userPass.dispatchEvent(new Event('pwupdate'));
            } else {
            }

            bindToggleButton();

            if (parseInt(toggleButton.dataset.startMasked, 10) !== 1) {
                userPass.type = 'text';
            } else {
                toggleButton.click();
            }

            document.getElementById('pw-weak-text-label').textContent = 'Confirm use of weak password';

            if (userPass.id !== 'mailserver_pass') {
                userPass.focus();
            }
        }

        function bindPass1() {
            generatePassword();
        }

        function resetToggle(show) {
            toggleButton.setAttribute('aria-label', show ? 'Show password' : 'Hide password');
            toggleButton.querySelector('.text').textContent = show ? 'Show' : 'Hide';
            const eyeIcon = toggleButton.querySelector('.eye-icon');
            eyeIcon.innerHTML = show ? '<i class="far fa-eye"></i>' : '<i class="far fa-eye-slash"></i>';
        }

        function bindToggleButton() {
            if (toggleButton) {
                return;
            }
            toggleButton = pass1Row.querySelector('.wp-hide-pw');
            toggleButton.style.display = 'inline-block';
            toggleButton.addEventListener('click', function() {
                if (userPass.type === 'password') {
                    userPass.type = 'text';
                    resetToggle(false);
                } else {
                    userPass.type = 'password';
                    resetToggle(true);
                }
            });
        }

        function bindPasswordForm() {
            let generateButton;

            pass1Row = document.querySelector('.user-pass1-wrap');
            userPass = document.querySelector('#pass1');
            if (userPass) {
                bindPass1();
            } else {
                userPass = document.querySelector('#user_pass');
            }

            if (userPass.hidden) {
                userPass.disabled = true;
            }

            passwordWrapper = pass1Row.querySelector('.wp-pwd');
            generateButton = pass1Row.querySelector('button.wp-generate-pw');

            bindToggleButton();

            generateButton.style.display = 'inline-block';
            generateButton.addEventListener('click', function() {
                passwordWrapper.style.display = 'block';
                passwordWrapper.classList.add('is-open');
                pass1.disabled = false;
                generatePassword();
                resetToggle(false);
                
                fetch('/generate-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    userPass.dataset.pw = data;
                    userPass.value = data;
                    userPass.dispatchEvent(new Event('pwupdate'));
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        }

        function removeEyeIconSVG() {
            const eyeIconSpan = document.querySelector('.eye-icon');
            if (eyeIconSpan) {
                eyeIconSpan.innerHTML = '';
            }
        }

        window.generatePassword = generatePassword;
        document.addEventListener('DOMContentLoaded', function() {
            bindPasswordForm();
        });
    </script>
</form>