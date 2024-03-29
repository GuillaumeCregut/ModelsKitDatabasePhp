<?php

namespace Editiel98\Manager;

use DateTime;
use DateTimeZone;
use Editiel98\App;
use Editiel98\Database\Database;
use Editiel98\DbException;
use Editiel98\Entity\User;
use Exception;

class UserManager extends Manager
{
    public function __construct(Database $db)
    {
        $this->db = $db;
        $this->table = 'user';
        $this->className = 'Editiel98\Entity\User';
    }

    /**
     * 
     * @param int $id
     * 
     * @return User
     */
    public function findById(int $id): User|bool
    {
        try {
            $query = "SELECT firstname, lastname, email, login,isVisible, avatar, allow, rankUser, id, isvalid FROM " . $this->table . " WHERE id=:id";
            $values = [':id' => $id];
            $result = $this->db->prepare($query, null, $values, true);
            if ($result) {
                $user = new User();
                $user->setFirstname($result->firstname);
                $user->setLastname($result->lastname);
                $user->setEmail($result->email);
                $user->setlogin($result->login);
                $user->setId($result->id);
                $user->setValid($result->isvalid);
                $user->setAllow($result->allow);
                $user->setVisible($result->isVisible);
                if (is_null($result->avatar)) {
                    $avatar = '';
                } else  $avatar = $result->avatar;
                $user->setAvatar($avatar);
                $user->setRankUser($result->rankUser);
                return $user;
            } else return false;
        } catch (DbException $e) {
            return false;
        }
    }

    /**
     * @param string $mail
     * 
     * @return [type]
     */
    public function findByMail(string $mail)
    {
        try {
            $query = "SELECT id, firstname, lastname, isvalid, email,allow,isVisible,login,avatar,rankUser FROM " . $this->table . " WHERE email=:email";
            $values = [':email' => $mail];
            $result = $this->db->prepare($query, null, $values, true);
            if ($result) {
                $user = new User();
                $user->setFirstname($result->firstname);
                $user->setLastname($result->lastname);
                $user->setEmail($result->email);
                $user->setlogin($result->login);
                $user->setId($result->id);
                $user->setValid($result->isvalid);
                $user->setAllow($result->allow);
                $user->setVisible($result->isVisible);
                if (is_null($result->avatar)) {
                    $avatar = '';
                } else  $avatar = $result->avatar;
                $user->setAvatar($avatar);
                $user->setRankUser($result->rankUser);
                return $user;
            } else return null;
        } catch (DbException $e) {
            return false;
        }
    }


    /**
     * @return array
     */
    public function getAll(): array
    {
        try {
            $result = $this->db->query('SELECT id,rankUser,firstname,lastname, isvalid FROM ' . $this->table);
            return $result;
        } catch (DbException $e) {
            $this->loadErrorPage($e->getdbMessage());
        }
    }

    /**
     * 
     * @param string $login
     * 
     * @return User
     */
    public function findByName(string $login): User|bool
    {
        try {
            $query = "SELECT firstname, lastname,email, rankUser, id, email, isvalid FROM " . $this->table . " WHERE login=:login";
            $classname = 'Editiel98\Entity\User';
            $values = [':login' => $login];
            $result = $this->db->prepare($query, $classname, $values, true);
            return $result;
        } catch (DbException $e) {
            throw new Exception($e->getdbMessage());
        }
    }

    /**
     * @param User $entity
     * 
     * @return bool
     */
    public function update(User $entity): bool
    {
        $query = "UPDATE " . $this->table . " SET 
        firstname=:firstname,
        lastname=:lastname,
        login=:login,
        email=:email,
        isVisible=:visible,
        allow=:allow,
        avatar=:avatar
        ";
        if ($entity->getPassword() !== '') {
            $query .= " password=:password";
            $values[':password'] = $entity->getPassword();
        }
        $query .= " WHERE id=:id";
        $values[':firstname'] = $entity->getFirstname();
        $values[':lastname'] = $entity->getLastname();
        $values[':login'] = $entity->getLogin();
        $values[':email'] = $entity->getEmail();
        $values[':visible'] = $entity->getVisible();
        $values[':allow'] = $entity->getAllow();
        $values[':avatar'] = $entity->getAvatar();
        $values[':id'] = $entity->getId();
        try {
            $result = $this->db->exec($query, $values);
            return $result;
        } catch (DbException $e) {
            return false;
        }
        return false;
    }

    /**
     * unused method
     * @param User $entity
     * 
     * @return bool
     */
    public function save(User $entity): bool
    {
        return false;
    }

    /**
     * unused method
     * @param User $entity
     * 
     * @return bool
     */
    public function delete(User $entity): bool
    {
        return false;
    }

    /**
     * @param int $user
     * @param bool $status
     * 
     * @return bool
     */
    public function setNewStatus(int $user, bool $status): bool
    {
        $query = "UPDATE " . $this->table . " SET isvalid=:valid WHERE id=:id";
        $values = [":valid" => $status, ":id" => $user];
        try {
            $test = $this->db->exec($query, $values);
            return $test;
        } catch (DbException $e) {
            throw new Exception($e->getdbMessage());
        }
    }

    /**
     * @param int $user
     * @param int $role
     * 
     * @return bool
     */
    public function setNewRole(int $user, int $role): bool
    {
        $query = "UPDATE " . $this->table . " SET rankUser=:rankUser WHERE id=:id";
        $values = [":rankUser" => $role, ":id" => $user];
        try {
            $test = $this->db->exec($query, $values);
            return $test;
        } catch (DbException $e) {
            throw new Exception($e->getdbMessage());
        }
    }

    /**
     * get token for reset password for a user
     * @param string $email
     * 
     * @return [type]
     */
    public function getResetCredentials(string $email)
    {
        $query = "SELECT id, pwdtoken, pwdTokenDate, isvalid, email FROM user WHERE email=:email";
        $values = [
            ':email' => $email
        ];
        try {
            $result = $this->db->prepare($query, null, $values, true);
            return $result;
        } catch (DbException $e) {
            return false;
        }
    }

    /**
     * Set reset token for a user to change password
     * @param int $id : user id
     * @param string $code : token
     * 
     * @return [type]
     */
    public function setResetCode(int $id, string $code)
    {
        $mysql_date_now = new DateTime('now', new DateTimeZone('Europe/Paris'));
        $mysql_date_now->modify('+1 day');
        $expireDate = $mysql_date_now->format('Y-m-d H:i:s');
        $query = "UPDATE user SET pwdtoken=:code, pwdTokenDate=:newDate  WHERE id=:id";
        $values = [
            ':id' => $id,
            ':code' => $code,
            ':newDate' => $expireDate
        ];
        try {
            return $this->db->exec($query, $values);
        } catch (DbException $e) {
            return false;
        }
    }

    /**
     * @param int $id :user id
     * @param string $newPass
     * 
     * @return [type]
     */
    public function resetPassword(int $id, string $newPass)
    {
        $query = "UPDATE user SET passwd=:pass, pwdtoken=null, pwdTokenDate=null WHERE id=:id";
        $values = [
            ':pass' => $newPass,
            ':id' => $id
        ];
        try {
            $test = $this->db->exec($query, $values);
            return $test;
        } catch (DbException $e) {
            return false;
        }
    }

    /**
     * get user's favorite models
     * @param User $user
     * 
     * @return array
     */
    public function getFavorites(User $user): array
    {
        $userId = $user->getId();
        $query = "SELECT model as idModel FROM model_favorite WHERE owner=:owner";
        $values = ['owner' => $userId];
        try {
            $test = $this->db->prepare($query, null, $values);
            return $test;
        } catch (DbException $e) {
            throw new Exception($e->getdbMessage());
        }
    }

    /**
     * get user's models
     * @param User $user
     * 
     * @return array
     */
    public function getMyModels(User $user): array
    {
        $userId = $user->getId();
        $query = "SELECT id, idModel,state, pictures,price, stateName, modelName, reference, boxPicture,builderName, scaleName, brandName, providerName 
        FROM mymodels WHERE owner=:id";
        $values = [':id' => $userId];
        try {
            $result = $this->db->prepare($query, null, $values);
            if ($result) {
                return $result;
            } else return [];
        } catch (DbException $e) {
            throw new Exception($e->getdbMessage());
        }
    }

    /**
     * add a favorite model to user
     * @param User $user
     * @param int $idModel
     * 
     * @return bool
     */
    public function addFavorite(User $user, int $idModel): bool
    {
        $query = 'INSERT model_user (state,owner,model) VALUES (' . App::STATE_LIKED . ',:user,:model)';
        $values = [':user' => $user->getId(), ':model' => $idModel];
        $result = $this->db->exec($query, $values);
        return $result;
    }

    /**
     * @param User $user
     * @param int $idModel
     * 
     * @return bool
     */
    public function removeFavorite(User $user, int $idModel): bool
    {
        $query = 'DELETE FROM model_user WHERE state=' . App::STATE_LIKED . ' AND owner=:user AND model=:model';
        $values = [':user' => $user->getId(), ':model' => $idModel];
        $result = $this->db->exec($query, $values);
        return $result;
    }

    /**
     * Add a model to user's stock
     * @param User $user
     * @param int $idModel
     * @param int|null $provider
     * @param float|null $price
     * 
     * @return bool
     */
    public function addModelStock(User $user, int $idModel, ?int $provider = null, ?float $price = null): bool
    {
        if (is_null($provider)) {
            $query = 'INSERT model_user (state,owner,model) VALUES (:state,:user,:model)';
            $values = [':user' => $user->getId(), ':model' => $idModel, ':state' => App::STATE_STOCK];
        } else {
            $query = 'INSERT model_user (state,owner,model,provider,price) VALUES (:state,:user,:model,:provider,:price)';
            $values = [
                ':user' => $user->getId(),
                ':model' => $idModel,
                ':provider' => $provider,
                ':price' => $price,
                ':state' => App::STATE_BUY
            ];
        }
        $result = $this->db->exec($query, $values);
        return $result;
    }

    /**
     * get user's providers
     * @param User $entity
     * 
     * @return array
     */
    public function getProviders(User $entity): array
    {
        $idUser = $entity->getId();
        $classname = 'Editiel98\Entity\Provider';
        $query = 'SELECT id, name FROM provider WHERE owner=:id';
        $values = [':id' => $idUser];
        try {
            return $this->db->prepare($query, $classname, $values);
        } catch (DbException $e) {
            throw new Exception($e->getdbMessage());
        }
    }

    /**
     * get user's orders
     * @param User $entity
     * 
     * @return array
     */
    public function getOrders(User $entity, array $filters): array
    {
        $query = "SELECT o.provider, o.owner,o.reference,DATE_FORMAT(o.dateOrder,\"%d/%m/%Y\") as dateOrder, p.name 
        FROM orders o INNER JOIN provider p ON o.provider=p.id 
        WHERE o.owner=:id ";
        if (!empty($filters)) {
            switch ($filters[0]) {
                case 'reference':
                    $name = 'o.reference';
                    break;
                case 'supplier':
                    $name = 'p.name';
                    break;
                case 'date':
                    $name='o.dateOrder';
            }
            $query.="ORDER BY ".$name." ". $filters[1];
        } else {
            $query.="ORDER BY o.dateOrder DESC";
        }
        $values = [':id' => $entity->getId()];
        try {
            return $this->db->prepare($query, null, $values);
        } catch (DbException $e) {
            throw new Exception($e->getdbMessage());
        }
    }

    /**
     * remove a model in user's stock
     * @param int $id
     * @param int $user
     * 
     * @return bool
     */
    public function deleteModelFromStock(int $id, int $user): bool
    {
        //Vérifier si il y a des photos dans le kit, si oui, les supprimer, et supprimer le répertoire qui va bien
        $queryKit = "SELECT owner, id,state,pictures FROM model_user WHERE id=:id";
        $valuesKit = [':id' => $id];
        try {
            $theKit = $this->db->prepare($queryKit, null, $valuesKit, true);
            if ($theKit) {
                if ($theKit->owner !== $user) return false;
                if ($theKit->pictures) {
                    //Delete pictures 
                }
                //delete from db
                $query = "DELETE FROM model_user WHERE id=:id";
                try {
                    return $this->db->exec($query, $valuesKit);
                } catch (DbException $e) {
                    return false;
                }
            } else return false; //The kit does not exists, so no need to do more
        } catch (DbException $e) {
            echo "Erreur";
            return false;
        }
        return false;
    }

    /**
     * get user's models filtered and by state
     * @param int $state : state of model
     * @param int $user
     * @param string|null $filter
     * @param array|null $sorted [column,ASC/DESC]
     * 
     * @return array
     */
    public function getKitByState(int $state, int $user, ?string $filter = '', ?array $sorted = []): array
    {
        $query = "SELECT id, pictures, modelName, reference, boxPicture,builderName, scaleName, brandName 
        FROM mymodels WHERE state=:state AND owner=:owner";
        $values = [
            ':state' => $state,
            ':owner' => $user
        ];
        if ($filter !== '') {
            $query .= ' AND modelName like :name';
            $values[':name'] = "%{$filter}%";
        }
        if (!empty($sorted)) {
            $query .= ' ORDER BY ' . $sorted[0] . ' ' . $sorted[1];
        }
        try {
            return $this->db->prepare($query, null, $values);
        } catch (DbException $e) {
            return [];
        }
    }

    /**
     * get a random kit from user's stock
     * @param int $user
     * 
     * @return [type] array with model info
     */
    public function getRandomKit(int $user)
    {
        $query = "SELECT id,modelName,reference,boxPicture,builderName,scaleName,brandName 
        FROM mymodels WHERE owner=:owner AND state=:state ORDER BY RAND() LIMIT 1";
        $values = [
            ':owner' => $user,
            ':state' => App::STATE_STOCK
        ];
        try {
            return $this->db->prepare($query, null, $values, true);
        } catch (DbException $e) {
            return null;
        }
    }

    /**
     * @param int $user
     * 
     * @return bool
     */
    public function removeUser(int $user): bool
    {
        try {
            $this->db->startTransac();
            if (!$this->deleteMessages($user)) {
                $this->db->rollBack();
                return false;
            };
            if (!$this->deleteModelMessages($user)) {
                $this->db->rollBack();
                return false;
            };
            if (!$this->deleteFriend($user)) {
                $this->db->rollBack();
                return false;
            };
            if (!$this->deleteOrders($user)) {
                $this->db->rollBack();
                return false;
            };
            if (!$this->deleteModels($user)) {
                $this->db->rollBack();
                return false;
            };
            if (!$this->deleteProvider($user)) {
                $this->db->rollBack();
                return false;
            };
            $query = "DELETE from user WHERE id=:user";
            $value = [':user' => $user];
            try {
                $this->db->exec($query, $value);
            } catch (DbException $e) {
                $this->db->rollBack();
                return false;
            }
            $this->db->commitTransc();
            $this->removeDir($user);
            return true;
        } catch (DbException $e) {
            $this->db->rollBack();
            return false;
        }
    }


    /**
     * Remove user directory
     * @param int $user
     * 
     * @return void
     */
    private function removeDir(int $user): void
    {
        $dir = dirname(dirname(dirname(__DIR__))) . '/public/assets/uploads/users/' . $user . '/';
        $this->rrmdir($dir);
    }

    /**
     * remove a directory
     * @param mixed $dir
     * 
     * @return void
     */
    private function rrmdir($dir): void
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir . DIRECTORY_SEPARATOR . $object) && !is_link($dir . "/" . $object))
                        $this->rrmdir($dir . DIRECTORY_SEPARATOR . $object);
                    else
                        unlink($dir . DIRECTORY_SEPARATOR . $object);
                }
            }
            rmdir($dir);
        }
    }

    /**
     * Remove all users' messages
     * @param int $user
     * 
     * @return bool
     */
    private function deleteMessages(int $user): bool
    {
        $query = "DELETE FROM private_message WHERE exp=:user OR dest=:user";
        $value = [':user' => $user];
        try {
            $this->db->exec($query, $value);
            return true;
        } catch (DbException $e) {
            return false;
        }
    }

    /**
     * @param int $user
     * 
     * @return bool
     */
    private function deleteModelMessages(int $user): bool
    {
        $query = "DELETE FROM model_message WHERE fk_author=:user";
        $value = [':user' => $user];
        try {
            $this->db->exec($query, $value);
            return true;
        } catch (DbException $e) {
            return false;
        }
    }

    /**
     * @param int $user
     * 
     * @return bool
     */
    private function deleteFriend(int $user): bool
    {
        $query = "DELETE FROM friend WHERE id_friend1=:user OR id_friend2=:user";
        $value = [':user' => $user];
        try {
            $this->db->exec($query, $value);
            return true;
        } catch (DbException $e) {
            return false;
        }
    }

    /**
     * @param int $user
     * 
     * @return bool
     */
    private function deleteOrders(int $user): bool
    {
        // 4/ GET ORDERS, deletes all where id orders
        $query = "SELECT reference FROM orders WHERE owner=:user";
        $value = [':user' => $user];
        try {
            $orders = $this->db->prepare($query, null, $value, true);
            if ($orders) {
                foreach ($orders as $order) {
                    $query2 = "DELETE FROM model_order WHERE order_id={$order}";
                    try {
                        $this->db->exec($query2, []);
                    } catch (DbException $e) {
                        return false;
                    }
                }
            }
        } catch (DbException $e) {
            return false;
        }
        // 5/ Delete orders
        $query = "DELETE FROM orders WHERE owner=:user";
        try {
            $this->db->exec($query, $value);
            return true;
        } catch (DbException $e) {
            return false;
        }
    }

    /**
     * @param int $user
     * 
     * @return bool
     */
    private function deleteModels(int $user): bool
    {
        $query = "DELETE FROM model_user WHERE owner=:user";
        $value = [':user' => $user];
        try {
            $this->db->exec($query, $value);
            return true;
        } catch (DbException $e) {
            return false;
        }
    }

    /**
     * @param int $user
     * 
     * @return bool
     */
    private function deleteProvider(int $user): bool
    {
        $query = "DELETE FROM provider WHERE owner=:user";
        $value = [':user' => $user];
        try {
            $this->db->exec($query, $value);
            return true;
        } catch (DbException $e) {
            return false;
        }
    }
}
