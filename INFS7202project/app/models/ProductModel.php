 <?php
class ProductModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }


    public function uploadNewProduct($data) {
        $this->db->query('SELECT pid FROM products WHERE pid=(SELECT MAX(pid) FROM products)');
        $this->db->execute();
        $row = $this->db->single();
        $newproductID = $row->pid + 1;
        $imgPath = $this->uploadImage($newproductID, $data['uid'], $data['img']);
        $this->db->query('INSERT INTO products (uid,pid,price,short_des,long_des,quantity,imagePath) VALUES(:uid,:pid,:price,:short_des,:long_des,:quantity,:imagePath);');
        $this->db->bind(':uid', $data['uid']);
        $this->db->bind(':pid', $newproductID);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':short_des', $data['short_des']);
        $this->db->bind(':long_des', $data['long_des']);
        $this->db->bind(':quantity', $data['quantity']);
        $this->db->bind(':imagePath', $imgPath);
        try {
            $this->db->execute();
        } catch (PDOException $e) {
            echo '</br>FAILED product: ' . $e->getMessage() . '</br>';
            return false;
        }
        return true;
    }

    public function updateProduct($data) {
        $this->db->query('UPDATE products SET price=:price, short_des=:short_des, long_des=:long_des, quantity=:quantity WHERE pid=:pid;');
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':short_des', $data['short_des']);
        $this->db->bind(':long_des', $data['long_des']);
        $this->db->bind(':quantity', $data['quantity']);
        $this->db->bind(':pid', $data['pid']);
        try {
            $this->db->execute();
        } catch (PDOException $e) {
            echo '</br>FAILED Product: ' . $e->getMessage() . '</br>';
            return false;
        }
        return true;
    }

    private function uploadImage($pid, $uid, $imgTemp) {
        if($imgTemp['size'] > 0) {
            $orginalNameExplode = explode('.', $imgTemp['name']);
            $extension = end($orginalNameExplode);
            $uploadName = 'p'.$pid.'_u'.$uid.'_preview.'.$extension;
            $uploadPath = '/'.$uploadName;
            if(!file_exists($uploadPath)) {
                move_uploaded_file($imgTemp['tmp_name'], dirname(APPROOT) . '/public/images/products'.$uploadPath);
                return $uploadPath;
            }
        }
        // Default placeholder image path
        return '/default.png';;
    }

    public function getProductData($pid) {
        $this->db->query('SELECT * FROM products WHERE pid=:pid');
        $this->db->bind(':pid', $pid);
        $this->db->execute();
        $productResult = $this->db->single();
        if($productResult == null) {
            return null;
        }
        $productResult = (array)$productResult;
        $this->db->query('SELECT username FROM users WHERE id=:uid');
        $this->db->bind(':uid', $productResult['uid']);
        $this->db->execute();
        $result = $this->db->single();
        $productResult['username'] = $result->username;
        return (object)$productResult;
    }


    public function getAllProducts() {
        $this->db->query('SELECT * FROM products');
        $this->db->execute();
        return $this->db->resultSet();
    }

    public function searchProducts($query) {
        $query = '%'.$query.'%';
        $this->db->query('SELECT * FROM products WHERE ( short_des LIKE ? OR long_des LIKE ? )');
        $this->db->bind(1, $query);
        $this->db->bind(2, $query);
        return $this->db->resultSet();
    }

    public function searchProductName($query) {
        $query = '%'.$query.'%';
        $this->db->query('SELECT * FROM products WHERE ( short_des LIKE ? )');
        $this->db->bind(1, $query);
        return $this->db->resultSet();
    }

    public function getAverageRating($pid){
        $comments = $this->getAllComments($pid);
        $sum = 0;
        if(sizeof($comments)!=0){
            foreach($comments as $comment){
                $sum += $comment->rating;
            }
            return $sum/sizeof($comments);
        } else {
            return $sum;
        }
    }


    public function addNewComment($data){
        $this->db->query("INSERT INTO comments (comment_description, rating, pid, uid) VALUES (:description, :rating, :pid, :uid)");
        $this->db->bind(':description', $data['comment']);
        $this->db->bind(':rating', $data['rating']);
        $this->db->bind(':pid', $data['pid']);
        $this->db->bind(':uid',$_SESSION['user_id']);
        try {
            $this->db->execute();
        } catch (PDOException $e) {
            return false;
        }

        $this->db->query('SELECT comments.*, users.username FROM comments JOIN users ON uid=id WHERE cid = (SELECT MAX(cid) FROM comments)');
        return $this->db->single();
    }

    public function getAllComments($pid) {
        $this->db->query('SELECT comments.*, users.username FROM comments JOIN users ON uid=id 
                WHERE pid = :pid  ORDER BY date DESC');
        $this->db->bind(':pid', $pid);
        return $this->db->resultSet();
    }

    /**
     * TODO: dont use hard coded value
     *
     * @return: object of recipe data
     */
    public function getNewProducts(){
      $this->db->query("SELECT * FROM products ORDER BY pid DESC LIMIT :num");
      $this->db->bind(':num', 6);
      return $this->db->resultSet();

    }

}
