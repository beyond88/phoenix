<form class="mb-9">
    <div class="row g-3 flex-between-end mb-5">
        <div class="col-auto">
            <h2 class="mb-2">Add New User</h2>
            <h5 class="text-body-tertiary fw-semibold">Create a brand new user and add them to this site.</h5>
        </div>
        <div class="col-auto">
            <a href="{{ url('admin/users') }}" class="btn btn-phoenix-secondary me-2 mb-2 mb-sm-0" type="button">Discard</a>
            <button class="btn btn-primary mb-2 mb-sm-0" id="createnewuser" type="button" wire:click="">Add New User</button>
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

            <div class="user-pass1-wrap">
                <button class="btn btn-outline-primary me-2 mb-2 wp-generate-pw hide-if-no-js" type="button">Generate password</button>

                @php
                    $initial_password = generate_password( 24 );
                @endphp
                <div class="wp-pwd is-open">
                    <div class="password-input-wrapper">
                        <span class="lp-password-input">
                            <input class="form-control strong" 
                                type="text" 
                                id="pass1"
                                data-pw="{{ $initial_password }}"
                                value="{{ $initial_password }}"
                                wire:model="password" />
                            <span class="lp-show-password-input"></span>
                        </span>
                        <div id="pass-strength-result" aria-live="polite" class="strong">Strong</div>
                    </div>

                    <button type="button" class="btn btn-outline-primary button wp-hide-pw hide-if-no-js" data-toggle="0" aria-label="Hide password">
                        <span class="eye-icon">
                            <i class="far fa-eye-slash"></i>
                        </span>
                        <span class="text">Hide</span>
                    </button>
                </div>
            </div>

            <div class="pw-weak" style="display: none;">
                <h4>Confirm Password</h4>
                <div>
                    <label>
                        <input type="checkbox" name="pw_weak" class="pw-checkbox">
                        Confirm use of weak password			
                    </label>
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
	wp.passwordStrength = {
		meter : function( password1, disallowedList, password2 ) {
			if ( ! Array.isArray( disallowedList ) )
				disallowedList = [ disallowedList.toString() ];

			if (password1 != password2 && password2 && password2.length > 0)
				return 5;

			if ( 'undefined' === typeof window.zxcvbn ) {
				return -1;
			}

			var result = zxcvbn( password1, disallowedList );
			return result.score;
		},

		userInputBlacklist : function() {
			window.console.log(
				sprintf(
					__( '%1$s is deprecated since version %2$s! Use %3$s instead. Please consider writing more inclusive code.' ),
					'wp.passwordStrength.userInputBlacklist()',
					'5.5.0',
					'wp.passwordStrength.userInputDisallowedList()'
				)
			);

			return wp.passwordStrength.userInputDisallowedList();
		},

		userInputDisallowedList : function() {
			var i, userInputFieldsLength, rawValuesLength, currentField,
				rawValues       = [],
				disallowedList  = [],
				userInputFields = [ 'user_login', 'first_name', 'last_name', 'nickname', 'display_name', 'email', 'url', 'description', 'weblog_title', 'admin_email' ];

			rawValues.push( document.title );
			rawValues.push( document.URL );

			userInputFieldsLength = userInputFields.length;
			for ( i = 0; i < userInputFieldsLength; i++ ) {
				currentField = $( '#' + userInputFields[ i ] );

				if ( 0 === currentField.length ) {
					continue;
				}

				rawValues.push( currentField[0].defaultValue );
				rawValues.push( currentField.val() );
			}

			rawValuesLength = rawValues.length;
			for ( i = 0; i < rawValuesLength; i++ ) {
				if ( rawValues[ i ] ) {
					disallowedList = disallowedList.concat( rawValues[ i ].replace( /\W/g, ' ' ).split( ' ' ) );
				}
			}

			disallowedList = $.grep( disallowedList, function( value, key ) {
				if ( '' === value || 4 > value.length ) {
					return false;
				}

				return $.inArray( value, disallowedList ) === key;
			});

			return disallowedList;
		}
	};

	window.passwordStrength = wp.passwordStrength.meter;


    let updateLock = false,
    isSubmitting = false,
    pass1Row,
    pass1,
    pass2,
    weakRow,
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
        } else if (!pass1.value || passwordWrapper.classList.contains('is-open')) {
            pass1.value = pass1.dataset.pw;
            pass1.dispatchEvent(new Event('pwupdate'));
            showOrHideWeakPasswordCheckbox();
        } else {
            check_pass_strength();
            showOrHideWeakPasswordCheckbox();
        }

        bindToggleButton();

        if (parseInt(toggleButton.dataset.startMasked, 10) !== 1) {
            pass1.type = 'text';
        } else {
            toggleButton.click();
        }

        document.getElementById('pw-weak-text-label').textContent = 'Confirm use of weak password';

        if (pass1.id !== 'mailserver_pass') {
            pass1.focus();
        }
    }

    function bindPass1() {
        currentPass = pass1.value;

        if (parseInt(pass1.dataset.reveal, 10) === 1) {
            generatePassword();
        }

        function handlePass1Input() {
            if (pass1.value === currentPass) {
                return;
            }
            currentPass = pass1.value;
            pass1.classList.remove('short', 'bad', 'good', 'strong');
            showOrHideWeakPasswordCheckbox();
        }

        pass1.addEventListener('input', handlePass1Input);
        pass1.addEventListener('pwupdate', handlePass1Input);
    }

    function resetToggle(show) {
        toggleButton.setAttribute('aria-label', show ? 'Show password' : 'Hide password');
        toggleButton.querySelector('.text').textContent = show ? 'Show' : 'Hide';
        const eyeIcon = toggleButton.querySelector('.eye-icon');
        // removeEyeIconSVG();
        eyeIcon.innerHTML = show ? '<i class="far fa-eye"></i>' : '<i class="far fa-eye-slash"></i>';
    }

    function bindToggleButton() {
        if (toggleButton) {
            return;
        }
        toggleButton = pass1Row.querySelector('.wp-hide-pw');
        toggleButton.style.display = 'inline-block';
        toggleButton.addEventListener('click', function() {
            if (pass1.type === 'password') {
                pass1.type = 'text';
                resetToggle(false);
            } else {
                pass1.type = 'password';
                resetToggle(true);
            }
        });
    }

    function bindPasswordResetLink() {
        document.getElementById('generate-reset-link').addEventListener('click', function() {
            let thisButton = this;
            let data = {
                'user_id': userProfileL10n.user_id,
                'nonce': userProfileL10n.nonce
            };

            thisButton.parentNode.querySelectorAll('.notice-error').forEach(el => el.remove());

            // wp.ajax.post('send-password-reset', data)
            // .done(function(response) {
            //     addInlineNotice(thisButton, true, response);
            // })
            // .fail(function(response) {
            //     addInlineNotice(thisButton, false, response);
            // });
        });
    }

    function addInlineNotice(thisButton, success, message) {
        let resultDiv = document.createElement('div');
        resultDiv.setAttribute('role', 'alert');
        resultDiv.classList.add('notice', 'inline', success ? 'notice-success' : 'notice-error');

        let paragraph = document.createElement('p');
        paragraph.textContent = message;
        resultDiv.appendChild(paragraph);

        thisButton.disabled = success;

        thisButton.parentNode.querySelectorAll('.notice').forEach(el => el.remove());

        thisButton.parentNode.insertBefore(resultDiv, thisButton);
    }

    function bindPasswordForm() {
        let generateButton, cancelButton;

        pass1Row = document.querySelector('.user-pass1-wrap');
        submitButton = document.querySelector('#createnewuser');
        submitButton.addEventListener('click', function() {
            updateLock = false;
        });

        submitButtons = [submitButton, ...document.querySelectorAll('#createnewuser')];

        weakRow = document.querySelector('.pw-weak');
        weakCheckbox = weakRow.querySelector('.pw-checkbox');
        weakCheckbox.addEventListener('change', function() {
            submitButtons.forEach(button => button.disabled = !weakCheckbox.checked);
        });

        pass1 = document.querySelector('#pass1');
        if (pass1) {
            bindPass1();
        } else {
            pass1 = document.querySelector('#user_pass');
        }

        if (pass1.hidden) {
            pass1.disabled = true;
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
                pass1.dataset.pw = data;
                pass1.value = data;
                pass1.dispatchEvent(new Event('pwupdate'));
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });

        // cancelButton = pass1Row.querySelector('button.wp-cancel-pw');
        // cancelButton.addEventListener('click', function() {
        //     updateLock = false;

        //     pass1.disabled = true;
        //     pass2.disabled = true;
        //     pass1.value = '';
        //     pass1.dispatchEvent(new Event('pwupdate'));
        //     resetToggle(false);
        //     passwordWrapper.style.display = 'none';
        //     passwordWrapper.classList.remove('is-open');
        //     submitButtons.forEach(button => button.disabled = false);
        //     generateButton.setAttribute('aria-expanded', 'false');
        // });

        // pass1Row.closest('form').addEventListener('submit', function() {
        //     updateLock = false;
        //     pass1.disabled = false;
        //     pass2.disabled = false;
        //     pass2.value = pass1.value;
        // });
    }

    function check_pass_strength() {
        let pass1 = document.getElementById('pass1').value;
        let strength;

        let passStrengthResult = document.getElementById('pass-strength-result');
        passStrengthResult.classList.remove('short', 'bad', 'good', 'strong', 'empty');

        if (!pass1 || pass1.trim() === '') {
            passStrengthResult.classList.add('empty');
            passStrengthResult.innerHTML = '&nbsp;';
            return;
        }

        strength = wp.passwordStrength.meter(pass1, wp.passwordStrength.userInputDisallowedList(), pass1);

        switch (strength) {
            case -1:
                passStrengthResult.classList.add('bad');
                passStrengthResult.innerHTML = pwsL10n.unknown;
                break;
            case 2:
                passStrengthResult.classList.add('bad');
                passStrengthResult.innerHTML = pwsL10n.bad;
                break;
            case 3:
                passStrengthResult.classList.add('good');
                passStrengthResult.innerHTML = pwsL10n.good;
                break;
            case 4:
                passStrengthResult.classList.add('strong');
                passStrengthResult.innerHTML = pwsL10n.strong;
                break;
            case 5:
                passStrengthResult.classList.add('short');
                passStrengthResult.innerHTML = pwsL10n.mismatch;
                break;
            default:
                passStrengthResult.classList.add('short');
                passStrengthResult.innerHTML = pwsL10n.short;
        }
    }

    function showOrHideWeakPasswordCheckbox() {
        let passStrengthResult = document.getElementById('pass-strength-result');

        if (passStrengthResult) {
            let passStrength = passStrengthResult;

            if (passStrength.className) {
                pass1.classList.add(passStrength.className);
                if (passStrength.classList.contains('short') || passStrength.classList.contains('bad')) {
                    if (!weakCheckbox.checked) {
                        submitButtons.forEach(button => button.disabled = true);
                    }
                    weakRow.style.display = 'block';
                } else {
                    if (passStrength.classList.contains('empty')) {
                        submitButtons.forEach(button => button.disabled = true);
                        weakCheckbox.checked = false;
                    } else {
                        submitButtons.forEach(button => button.disabled = false);
                    }
                    weakRow.style.display = 'none';
                }
            }
        }
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
        // bindPasswordResetLink();
    });
</script>
</form>