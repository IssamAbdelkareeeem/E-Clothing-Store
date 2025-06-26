<?php
class Product {
    private $id, $name, $category, $description, $price, $rating, $image, $quantity;

    public function __construct($id, $name, $category, $description, $price, $rating, $image, $quantity) {
        $this->id = $id;
        $this->name = $name;
        $this->category = $category;
        $this->description = $description;
        $this->price = $price;
        $this->rating = $rating;
        $this->image = $image;
        $this->quantity = $quantity;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getCategory() {
        return $this->category;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getRating() {
        return $this->rating;
    }

    public function getImage() {
        return $this->image;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function displayProductPage() {
        return "
        <main>
            <h2>{$this->name}</h2>
            <p><strong>ID:</strong> {$this->id}</p>
            <img src='images/{$this->image}' alt='{$this->name}' width='330'>
            <p><strong>Category:</strong> {$this->category}</p>
            <p><strong>Price:</strong> \${$this->price}</p>
            <p><strong>Quantity:</strong> {$this->quantity}</p>
            <p><strong>Rating:</strong> " . intval($this->rating) . "/5</p>
            <p><strong>Description:</strong> {$this->description}</p>
        </main>";
    }
}
?>
