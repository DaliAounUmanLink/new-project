// app/models/UserDTO.php
<?php
class UserDTO {
    public $id;
    public $username;
    public $email;

    public function __construct($id, $username, $email) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
    }
}
