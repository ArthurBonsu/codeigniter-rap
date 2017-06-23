<?php
  require __DIR__.'/../../db.php';
  require __DIR__.'/../../jwt.php';
  class Users extends CI_Controller {

    public function _remap($param){
      $this->index($param);
    }

    public function index($param){
      //echo password_hash(hash('sha512', '1234',true),PASSWORD_DEFAULT),"\n";
      $token = array();
      $token['id'] = '1337';
      //echo JWT::encode($token, 'my_key', 'HS512'),"\n";
      //header('Content-Type: application/json');
      if($this->input->method(true) == 'POST'){
        echo json_encode($this->create($_POST));
        return;
      }
      if($param=='index'){  // This is what it's empty looks like by default
        $data = $this->readAll();
        echo $data;
      }
      else {
        $data = $this->read($param);
        if($data == false)
          echo(json_encode(array('message'=>'No user with this username.')));
        else
          echo json_encode($data[0]);
      }
    }

    private function create($data){
      return database_query(
        "INSERT INTO
        `users` (`username`, `password`, `email`)
        VALUES (?,?,?)",
        "sss", [$data['username'], $data['password'], $data['email']], true);
    }

    private function readAll(){
      return database_no_args_query(
        "SELECT username, user_id AS id
        FROM users"
      );
    }

    private function read($username){
      if(empty($username))
        return array("message"=>"The specified username was empty.");
      return database_query(
        "SELECT username, user_id AS id
        FROM users
        WHERE username=?",
        "s", [$username]
      );
    }

    private function update($value=''){
      # code...
    }

    private function delete($value=''){
      # code...
    }

  }
?>
