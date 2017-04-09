<?php

// application/models/UserModel.class.php

class UserModel extends Model{


    public function getUsers(){

        $sql = "select * from $this->table";
        //$sql="update $this->table set nickname='chac' where id=172";
       // $sql="insert into $this->table (password,nickname,email,regtime) values ('assyyrasc s1','sasdhfbbvsdcgd1','dasdbcvcshds1','15ccfg1s5')";

        $users = $this->db->getOne($sql);

       // $users = $this->db->lastInsertId($sql);
       // print_r($users);

        return $users;
    }

}