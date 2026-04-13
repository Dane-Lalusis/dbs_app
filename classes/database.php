<?php
    class database{
        function opencon(): PDO{
            return new PDO(

        dsn: 'mysql:host=localhost;
            dbname=lalusislibrary3',
            username: 'root',
            password: '');
        } 

        function insertUser($email, $password_hash, $is_active){
            $con = $this->opencon();

            try{
                $con->beginTransaction();
                $stmt = $con->prepare('INSERT INTO Users (username, user_password_hash, is_active) VALUES (?, ?, ?)');
                $stmt->execute([$email, $password_hash, $is_active]);
                $user_id = $con->lastInsertId();
                $con->commit();

                return $user_id;

            }catch(PDOException $e){
                if($con->inTransaction()){
                    $con->rollBack();
                }
            }
        }

        function insertBorrowers($firstname, $lastname, $email, $phone, $member_since, $is_active){
            $con = $this->opencon();

            try{
                $con->beginTransaction();
                $stmt = $con->prepare('INSERT INTO Borrowers (borrower_firstname, borrower_lastname, borrower_email, borrower_phone_number, borrower_member_since, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
                $stmt->execute([$firstname, $lastname, $email, $phone, $member_since, $is_active]);
                $borrower_id = $con->lastInsertId();
                $con->commit();

                return $borrower_id;

            }catch(PDOException $e){
                if($con->inTransaction()){
                    $con->rollBack();
                }
            }
        }

        function insertBorrowerUser($user_id, $borrower_id){
            $con = $this->opencon();

            try{
                $con->beginTransaction();
                $stmt = $con->prepare('INSERT INTO Borrower_User (user_id, borrower_id) VALUES (?, ?)');
                $stmt->execute([$user_id, $borrower_id]);
                $bu_id = $con->lastInsertId();
                $con->commit();

                return true;

            } catch(PDOException $e){
                if($con->inTransaction()){
                    $con->rollBack();
                }
            }
        }

        function viewBorrowerUser(){
            $con =$this->opencon();
            return $con->query("SELECT * from Borrowers")->fetchAll();
        }

// dividah
        function insertBorrowerAddress($borrower_id, $ba_house_number, $ba_street, $ba_barangay, $ba_city, $ba_province, $ba_postal_code, $is_primary){
            $con = $this->opencon();

            try{
                $con->beginTransaction();
                $stmt = $con->prepare('INSERT INTO borrower_address (borrower_id, ba_house_number, ba_street, ba_barangay, ba_city, ba_province, ba_postal_code, is_primary) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
                $stmt->execute([$borrower_id, $ba_house_number, $ba_street, $ba_barangay, $ba_city, $ba_province, $ba_postal_code, $is_primary]);
                $ba_id = $con->lastInsertId();
                $con->commit();

                return true;

            }catch(PDOException $e){
                if($con->inTransaction()){
                    $con->rollBack();
                }
            }
        }

        function viewBorrowerAddress(){
            $con =$this->opencon();
            return $con->query("SELECT * from borrower_address")->fetchAll();
        }
    }

?>