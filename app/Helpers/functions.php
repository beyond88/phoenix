<?php
use Illuminate\Support\Facades\Validator;
use App\Models\Option;

if (!function_exists('add_option')) {
    function add_option($name, $value)
    {
        return Option::add($name, $value);
    }
}

if (!function_exists('update_option')) {
    function update_option($name, $value)
    {
        return Option::updateOption($name, $value);
    }
}

if (!function_exists('get_option')) {
    function get_option($name, $default = null)
    {
        return Option::getOption($name, $default);
    }
}

if (!function_exists('delete_option')) {
    function delete_option($name)
    {
        return Option::deleteOption($name);
    }
}

if (!function_exists('generate_password')) :

    function generate_password( $length = 12, $special_chars = true, $extra_special_chars = false ) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        if ( $special_chars ) {
            $chars .= '!@#$%^&*()';
        }
        if ( $extra_special_chars ) {
            $chars .= '-_ []{}<>~`+=,.;:/?|';
        }

        $password = '';
        for ( $i = 0; $i < $length; $i++ ) {
            $password .= substr( $chars, ph_rand( 0, strlen( $chars ) - 1 ), 1 );
        }

        return $password;
    }

endif;

if (!function_exists('ph_rand')) :

	function ph_rand($min = null, $max = null) {
		global $rnd_value;

		/*
		 * Some misconfigured 32-bit environments (Entropy PHP, for example)
		 * truncate integers larger than PHP_INT_MAX to PHP_INT_MAX rather than overflowing them to floats.
		 */
		$max_random_number = 3000000000 === 2147483647 ? (float) '4294967295' : 4294967295; // 4294967295 = 0xffffffff

		if ( null === $min ) {
			$min = 0;
		}

		if ( null === $max ) {
			$max = $max_random_number;
		}

		// We only handle ints, floats are truncated to their integer value.
		$min = (int) $min;
		$max = (int) $max;

		// Use PHP's CSPRNG, or a compatible method.
		static $use_random_int_functionality = true;
		if ( $use_random_int_functionality ) {
			try {
				// wp_rand() can accept arguments in either order, PHP cannot.
				$_max = max( $min, $max );
				$_min = min( $min, $max );
				$val  = random_int( $_min, $_max );
				if ( false !== $val ) {
					return absint( $val );
				} else {
					$use_random_int_functionality = false;
				}
			} catch ( Error $e ) {
				$use_random_int_functionality = false;
			} catch ( Exception $e ) {
				$use_random_int_functionality = false;
			}
		}

		/*
		 * Reset $rnd_value after 14 uses.
		 * 32 (md5) + 40 (sha1) + 40 (sha1) / 8 = 14 random numbers from $rnd_value.
		 */
		if ( strlen( $rnd_value ) < 8 ) {
			static $seed = '';
			$rnd_value  = md5( uniqid( microtime() . mt_rand(), true ) . $seed );
			$rnd_value .= sha1( $rnd_value );
			$rnd_value .= sha1( $rnd_value . $seed );
			$seed       = md5( $seed . $rnd_value );
		}

		// Take the first 8 digits for our value.
		$value = substr( $rnd_value, 0, 8 );

		// Strip the first eight, leaving the remainder for the next call to wp_rand().
		$rnd_value = substr( $rnd_value, 8 );

		$value = abs( hexdec( $value ) );

		// Reduce the value to be within the min - max range.
		$value = $min + ( $max - $min + 1 ) * $value / ( $max_random_number + 1 );

		return abs( (int) $value );
	}
endif;

function is_email($email) {
	$validator = Validator::make(['email' => $email], [
		'email' => 'required|email'
	]);

	return !$validator->fails();
}