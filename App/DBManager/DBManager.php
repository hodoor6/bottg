<?php

class DBManager
{
    public $db;

    public function __construct(MysqliDb $db)
    {
        $this->db = $db;
    }

    public function isUser($user_id)
    {
        $db = $this->db;
        $result = $db->where('user_id', $user_id)->getOne('users');
        if (isset($result['id'])) {
            return true;
        } else {
            return false;
        }
    }

    public function setToCloseDialogCron($user_id)
    {
        $db = $this->db;
        $content = array('cmd' => '', 'companion' => 0, 'search_rnd' => 0, 'search_boy' => 0,
            'search_girl' => 0);
        $db->where('user_id', $user_id)->update('users', $content);
    }

    //метод ищет диалоги которые долго ищут напарника(девушка)
    public function getClosedDialogsGirl($time)
    {
        $db = $this->db;
        $db->where('search_girl', '0', '!=');
        $res = $db->where('search_girl', $time, '<=')->get('users');
        return $res;
    }

    //метод ищет диалоги которые долго ищут напарника(парень)
    public function getClosedDialogsBoy($time)
    {
        $db = $this->db;
        $db->where('search_boy', '0', '!=');
        $res = $db->where('search_boy', $time, '<=')->get('users');
        return $res;
    }

    //метод ищет диалоги которые долго ищут напарника(парень)
    public function getClosedDialogsRnd($time)
    {
        $db = $this->db;
        $db->where('search_rnd', '0', '!=');
        $res = $db->where('search_rnd', $time, '<=')->get('users');
        return $res;
    }

    public function getUserInfo($user_id)
    {
        $db = $this->db;
        $result = $db->where('user_id', $user_id)->getOne('users');
        return $result;
    }

    public function getUserInfoByUserName($username)
    {
        $db = $this->db;
        $result = $db->where('username', $username)->getOne('users');
        return $result;
    }

    public function addUser($user_id)
    {
        $db = $this->db;
        $content = array('user_id' => $user_id, 'username' => '', 'cmd' => '', 'age' => 0, 'gender' => 0,
            'last_update' => 0, 'country' => '', 'city' => '', 'photo_profile' => '', 'rating' => 0);
        $id = $db->insert('users', $content);
        return $id;
    }

    public function getUsername($user_id)
    {
        $db = $this->db;
        $result = $db->where('user_id', $user_id)->getOne('users');
        return $result['username'];
    }

    public function setUsername($user_id, $username)
    {
        $db = $this->db;
        $content = array('username' => $username);
        $db->where('user_id', $user_id)->update('users', $content);
    }

    public function getRating($user_id)
    {
        $db = $this->db;
        $result = $db->where('user_id', $user_id)->getOne('users');
        return $result['rating'];
    }

    public function setRating($user_id, $rating)
    {
        if (stripos($rating, '.') !== false) {
            $rating = explode('.', $rating);
            $rating[1] = substr($rating[1], 0, 2);
            $rating = implode('.', $rating);
        }
        $db = $this->db;
        $content = array('rating' => $rating);
        $db->where('user_id', $user_id)->update('users', $content);
    }

    public function setCountChats($user_id, $c)
    {
        $db = $this->db;
        $content = array('count_chats' => $c);
        $db->where('user_id', $user_id)->update('users', $content);
    }

    public function getAge($user_id)
    {
        $db = $this->db;
        $result = $db->where('user_id', $user_id)->getOne('users');
        return $result['age'];
    }

    public function setAge($user_id, $age)
    {
        $db = $this->db;
        $content = array('age' => $age);
        $db->where('user_id', $user_id)->update('users', $content);
    }

    public function getRefer($user_id)
    {
        $db = $this->db;
        $result = $db->where('user_id', $user_id)->getOne('users');
        return $result['refer'];
    }

    public function setRefer($user_id, $refer)
    {
        $db = $this->db;
        $content = array('refer' => $refer);
        $db->where('user_id', $user_id)->update('users', $content);
    }

    public function getVipDay($user_id)
    {
        $db = $this->db;
        $result = $db->where('user_id', $user_id)->getOne('users');
        return $result['vip_day'];
    }

    public function setVipDay($user_id, $vip_day)
    {
        $db = $this->db;
        $content = array('vip_day' => $vip_day);
        $db->where('user_id', $user_id)->update('users', $content);
    }

    public function setCity($user_id, $city)
    {
        $db = $this->db;
        $content = array('city' => $city);
        $db->where('user_id', $user_id)->update('users', $content);
    }

    public function setCountry($user_id, $country)
    {
        $db = $this->db;
        $content = array('country' => $country);
        $db->where('user_id', $user_id)->update('users', $content);
    }

    public function setPhotoProfile($user_id, $photo)
    {
        $db = $this->db;
        $content = array('photo_profile' => $photo);
        $db->where('user_id', $user_id)->update('users', $content);
    }

    public function getCompanion($user_id)
    {
        $db = $this->db;
        $result = $db->where('user_id', $user_id)->getOne('users');
        return $result['companion'];
    }

    public function setCompanion($user_id, $companion)
    {
        $db = $this->db;
        $content = array('companion' => $companion);
        $db->where('user_id', $user_id)->update('users', $content);
    }

    public function setSearchRnd($user_id, $date)
    {
        $db = $this->db;
        $content = array('search_rnd' => $date);
        $db->where('user_id', $user_id)->update('users', $content);
    }

    public function setSearchBoy($user_id, $date)
    {
        $db = $this->db;
        $content = array('search_boy' => $date);
        $db->where('user_id', $user_id)->update('users', $content);
    }

    public function setSearchGirl($user_id, $date)
    {
        $db = $this->db;
        $content = array('search_girl' => $date);
        $db->where('user_id', $user_id)->update('users', $content);
    }

    public function SearchRnd()
    {
        $db = $this->db;
        $db->where('search_rnd', '0', '!=');
        $res = $db->orderBy('search_rnd', 'Asc')->get('users');
        return $res;
    }

    public function SearchBoy()
    {
        $db = $this->db;
        $db->where('search_boy', '0', '!=');
        $res = $db->orderBy('search_boy', 'Asc')->get('users');
        return $res;
    }

    public function SearchGirl()
    {
        $db = $this->db;
        $db->where('search_girl', '0', '!=');
        $res = $db->orderBy('search_girl', 'Asc')->get('users');
        return $res;
    }

    public function getLastUpdate($user_id)
    {
        $db = $this->db;
        $result = $db->where('user_id', $user_id)->getOne('users');
        return $result['last_update'];
    }

    public function setLastUpdate($user_id, $time = '')
    {
        if (empty($time)) $time = time();
        $db = $this->db;
        $content = array('last_update' => $time);
        $db->where('user_id', $user_id)->update('users', $content);
    }

    //date = 2020-07-02
    public function getCountNewUsersNowDay($date)
    {
        $db = $this->db;
        $res = $db->where('register_date', $date, '>=')->getValue('users', 'count(*)');
        return $res;
    }

    public function getCountUsersOnline($timestamp)
    {
        $db = $this->db;
        $res = $db->where('last_update', $timestamp, '>=')->get('users');
        return count($res);
    }

    public function countUsers()
    {
        $db = $this->db;
        $res = $db->getValue ("users", "count(*)");
        return $res;
    }

    public function getCmd($user_id)
    {
        $db = $this->db;
        $result = $db->where('user_id', $user_id)->getOne('users');
        return $result['cmd'];
    }

    public function setCmd($user_id, $cmd)
    {
        $db = $this->db;
        $content = array('cmd' => $cmd);
        $db->where('user_id', $user_id)->update('users', $content);
    }

    //метод обнуляет кол-во чатов до 0
    public function CountChatsNull()
    {
        $db = $this->db;
        $db->update('users', array('count_chats' => 0));
    }

    public function getGender($user_id)
    {
        $db = $this->db;
        $result = $db->where('user_id', $user_id)->getOne('users');
        return $result['gender'];
    }

    public function setGender($user_id, $gender)
    {
        $db = $this->db;
        $content = array('gender' => $gender);
        $db->where('user_id', $user_id)->update('users', $content);
    }

    public function getRegDate($user_id)
    {
        $db = $this->db;
        $res = $db->where('user_id', $user_id)->getOne('users');
        return $res['register_date'];
    }

    public function getAllUsersByLang($lang)
    {
        $db = $this->db;
        $res = $db->where('lang', $lang)->get('users');
        return $res;
    }

    public function countAllUsersByLang($lang)
    {
        $db = $this->db;
        $res = $db->where('lang', $lang)->getValue('users', 'count(*)');
        return $res;
    }

    public function getAllUsers()
    {
        $db = $this->db;
        $res = $db->get('users');
        return $res;
    }

    //GEO
    public function isCity($name)
    {
        $db = $this->db;
        $db->where('city', $name);
        $res = $db->getOne('geo');
        if (empty($res['id'])) {
            return false;
        }
        return true;
    }

    //получаем ближайшую страну по координатам
    public function getCountryByCoordinates($lat, $lng)
    {
        $db = $this->db;
        $query = "SELECT country, ( 3959 * acos( cos( radians(?) ) * cos( radians( lat ) )
            * cos( radians( lng ) - radians(?) ) + sin( radians(?) ) * sin(radians(lat)) ) ) AS distance 
FROM geo
HAVING distance < 50
ORDER BY distance LIMIT 1";
        $res = $db->rawQuery($query, [$lat, $lng, $lat]);
        return $res[0]['country'];
    }

    //получаем ближайший город по координатам
    public function getCityByCoordinates($lat, $lng)
    {
        $db = $this->db;
        $query = "SELECT city, ( 3959 * acos( cos( radians(?) ) * cos( radians( lat ) )
            * cos( radians( lng ) - radians(?) ) + sin( radians(?) ) * sin(radians(lat)) ) ) AS distance 
FROM geo
HAVING distance < 50
ORDER BY distance LIMIT 1";
        $res = $db->rawQuery($query, [$lat, $lng, $lat]);
        return $res[0]['city'];
    }

}