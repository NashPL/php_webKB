<?php

namespace App;

use Illuminate\Support\Facades\DB;

/**
 * A User class. Used to build a user object.
 */
class User
{

    private $id;
    private $email;
    private $password;
    private $country;
    private $validated;

    private $tableName = "users";

    /**
     * A class constructor desinged to build a user object.
     *
     * @param string $email
     * @param array $userDetails
     * @return void
     */
    public function __construct(string $email, array $userDetails)
    {
        $user = DB::table($this->tableName)->where('_email', $email)->first();
        if (is_null($user) || empty($user)) {
            $this->email = $email;
            $this->password = password_hash($userDetails['password'], PASSWORD_BCRYPT);
            $this->country = $userDetails['country'];
            $this->validated = false;
            $this->id = DB::table($this->tableName)->insert(
                ['_email' => $this->email, '_password' => $this->password,
                    '_country' => $this->country, '_validated' => $this->validated]
            );
        } else {
            $this->id = $user->_id;
            $this->email = $user->_email;
            $this->password = $user->_password;
            $this->country = $user->_country;
            $this->validated = $user->_validated;
        }
    }

    /**
     * Get user id.
     *
     * @return integer user database ID.
     */
    public function getId(): int
    {
        return $this->id;
    }

}
