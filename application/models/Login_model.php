<?php
/**
 * User: Michael
 * Date: 14.08.2017
 * Time: 18:07
 */

class Login_model extends CI_Model
{
    // перевіряємо чи є користувач в бaзі даних
    public function validation($login, $password){
        $this->db->where('login', $login);
        $this->db->where('password', sha1($password));
        $query = $this->db->get('users');

        // перевіряємо записи повенуті з БД, якщо = 1 то здійснюємо вхід
        if( $query->num_rows() == 1 ){
            foreach ($query->row() as $key => $value)
            { // створюємо сесію з відповідними полями (id, login, name, surnsme, email, remember_token, role) - oкрiм 'password'
                if($key !== 'password') $_SESSION[$key] = $value;
            }

            //користувача увійшо на сайт
            $_SESSION['open'] = true;

            // зберігаємо дату відвідування для користувача
            date_default_timezone_set('Europe/Kiev');
            $log = array(
                'id_user' => $_SESSION['id'],
                'date' => date('o-m-j G:i:s')
            );
            $this->db->insert('log', $log);

            // повертаємо true якщо користувач є
            return TRUE;
        }
        else{
            // якщо користувача немає то повертаємо false
            return FALSE;
        }
    }

    // вихід з особистого кабінету
    public function logout(){
        // якщо користувач виходить, то очищаємо сесію
        unset($_SESSION['open']);
        session_unset();
        redirect('/');
    }


} // end Login_model class