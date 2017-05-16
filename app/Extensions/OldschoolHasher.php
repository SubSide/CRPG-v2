<?php
namespace App\Extensions;

use App\Models\User;
use Illuminate\Hashing\BcryptHasher;

class OldschoolHasher extends BcryptHasher
{
    public function check($value, $hashedValue, array $options = [])
    {
        if (strlen($hashedValue) === 0) {
            return false;
        }


        if(!password_verify($value, $hashedValue)){

        }

        return password_verify($value, $hashedValue);
    }



    // These constants may be changed without breaking existing hashes.
    const PBKDF2_HASH_ALGORITHM = "sha1";
    const PBKDF2_ITERATIONS = 64000;
    const PBKDF2_SALT_BYTES = 24;
    const PBKDF2_OUTPUT_BYTES = 18;
    // These constants define the encoding and may not be changed.
    const HASH_SECTIONS = 5;
    const HASH_ALGORITHM_INDEX = 0;
    const HASH_ITERATION_INDEX = 1;
    const HASH_SIZE_INDEX = 2;
    const HASH_SALT_INDEX = 3;
    const HASH_PBKDF2_INDEX = 4;

    /**
     * Compares two strings $a and $b in length-constant time.
     *
     * @param string $a
     * @param string $b
     * @return bool
     */
    public static function slow_equals($a, $b)
    {
        if (!\is_string($a) || !\is_string($b)) {
            throw new \Exception(
                "slow_equals(): expected two strings"
            );
        }
        if (\function_exists('hash_equals')) {
            return \hash_equals($a, $b);
        }

        // PHP < 5.6 polyfill:
        $diff = self::ourStrlen($a) ^ self::ourStrlen($b);
        for($i = 0; $i < self::ourStrlen($a) && $i < self::ourStrlen($b); $i++) {
            $diff |= \ord($a[$i]) ^ \ord($b[$i]);
        }
        return $diff === 0;
    }

    public static function hash($password, $salt, $iteration_count){
        $password = sha1($password);
        $expl = str_split($password);
        $sum = 0;
        foreach($expl as $part){
            $sum += $part;
        }
        $iteration_count = $iteration_count + $sum;
        return self::pbkdf2('SHA256', $password, $salt, $iteration_count, 64);
    }

    /*
     * PBKDF2 key derivation function as defined by RSA's PKCS #5: https://www.ietf.org/rfc/rfc2898.txt
     * $algorithm - The hash algorithm to use. Recommended: SHA256
     * $password - The password.
     * $salt - A salt that is unique to the password.
     * $count - Iteration count. Higher is better, but slower. Recommended: At least 1000.
     * $key_length - The length of the derived key in bytes.
     * $raw_output - If true, the key is returned in raw binary format. Hex encoded otherwise.
     * Returns: A $key_length-byte key derived from the password and salt.
     *
     * Test vectors can be found here: https://www.ietf.org/rfc/rfc6070.txt
     *
     * This implementation of PBKDF2 was originally created by https://defuse.ca
     * With improvements by http://www.variations-of-shadow.com
     */
    private static function pbkdf2($algorithm, $password, $salt, $count, $key_length, $raw_output = false)
    {
        // Type checks:
        if (!\is_string($algorithm)) {
            throw new \Exception(
                "pbkdf2(): algorithm must be a string"
            );
        }
        if (!\is_string($password)) {
            throw new \Exception(
                "pbkdf2(): password must be a string"
            );
        }
        if (!\is_string($salt)) {
            throw new \Exception(
                "pbkdf2(): salt must be a string"
            );
        }
        // Coerce strings to integers with no information loss or overflow
        $count += 0;
        $key_length += 0;
        $algorithm = \strtolower($algorithm);
        if (!\in_array($algorithm, \hash_algos(), true)) {
            throw new \Exception(
                "Invalid or unsupported hash algorithm."
            );
        }
        // Whitelist, or we could end up with people using CRC32.
        $ok_algorithms = array(
            "sha1", "sha224", "sha256", "sha384", "sha512",
            "ripemd160", "ripemd256", "ripemd320", "whirlpool"
        );
        if (!\in_array($algorithm, $ok_algorithms, true)) {
            throw new \Exception(
                "Algorithm is not a secure cryptographic hash function."
            );
        }
        if ($count <= 0 || $key_length <= 0) {
            throw new \Exception(
                "Invalid PBKDF2 parameters."
            );
        }

        if (\function_exists("hash_pbkdf2")) {
            // The output length is in NIBBLES (4-bits) if $raw_output is false!
            if (!$raw_output) {
                $key_length = $key_length * 2;
            }
            return \hash_pbkdf2($algorithm, $password, $salt, $count, $key_length, $raw_output);
        }

        $hash_length = self::ourStrlen(\hash($algorithm, "", true));
        $block_count = \ceil($key_length / $hash_length);

        $output = "";
        for($i = 1; $i <= $block_count; $i++) {
            // $i encoded as 4 bytes, big endian.
            $last = $salt . \pack("N", $i);
            // first iteration
            $last = $xorsum = \hash_hmac($algorithm, $last, $password, true);
            // perform the other $count - 1 iterations
            for ($j = 1; $j < $count; $j++) {
                $xorsum ^= ($last = \hash_hmac($algorithm, $last, $password, true));
            }
            $output .= $xorsum;
        }

        if($raw_output) {
            return self::ourSubstr($output, 0, $key_length);
        } else {
            return \bin2hex(self::ourSubstr($output, 0, $key_length));
        }
    }
    /*
     * We need these strlen() and substr() functions because when
     * 'mbstring.func_overload' is set in php.ini, the standard strlen() and
     * substr() are replaced by mb_strlen() and mb_substr().
     */
    /**
     * Calculate the length of a string
     *
     * @param string $str
     * @return int
     */
    private static function ourStrlen($str)
    {
        static $exists = null;
        if ($exists === null) {
            $exists = \function_exists('mb_strlen');
        }

        if (!\is_string($str)) {
            throw new \Exception(
                "ourStrlen() expects a string"
            );
        }

        if ($exists) {
            $length = \mb_strlen($str, '8bit');
            if ($length === false) {
                throw new \Exception();
            }
            return $length;
        } else {
            return \strlen($str);
        }
    }
    /**
     * Substring
     *
     * @param string $str
     * @param int $start
     * @param int $length
     * @return string
     */
    private static function ourSubstr($str, $start, $length = null)
    {
        static $exists = null;
        if ($exists === null) {
            $exists = \function_exists('mb_substr');
        }
        // Type validation:
        if (!\is_string($str)) {
            throw new \Exception(
                "ourSubstr() expects a string"
            );
        }

        if ($exists) {
            // mb_substr($str, 0, NULL, '8bit') returns an empty string on PHP
            // 5.3, so we have to find the length ourselves.
            if (!isset($length)) {
                if ($start >= 0) {
                    $length = self::ourStrlen($str) - $start;
                } else {
                    $length = -$start;
                }
            }
            return \mb_substr($str, $start, $length, '8bit');
        }
        // Unlike mb_substr(), substr() doesn't accept NULL for length
        if (isset($length)) {
            return \substr($str, $start, $length);
        } else {
            return \substr($str, $start);
        }
    }
}