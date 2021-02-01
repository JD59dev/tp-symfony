<?php

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SuperCart {
    private $session;

    /**
     * Recovers other services in a service's constructor
     */
    public function __construct(SessionInterface $session) {
        $this->session = $session;
    }

    /**
     * Adds an item in the cart
     */
    public function addItem($item) {
        // Returns the products tab in session OR an empty tab
        $products = $this->session->get('products', []);
        $products[$item->getId()] = $item; // Index avoids doubles
        $this->session->set('products', $products);
    }

    /**
     * Checks if a product is already in the cart
     */
    public function hasItem($id) {
        $products = $this->session->get('products', []);

        return array_key_exists($id, $products);
    }

    /**
     * Recovers the cart's items
     */
    public function getItems() {
        return $this->session->get('products', []);
    }

    /**
     * Counts the items in the cart
     */
    public function count(): int {
        return count($this->session->get('products', []));
    }

    /**
     * Returns the cart's total price
     */
    public function total() {
        $products = $this->session->get('products');
        $total = 0;

        foreach($products as $product) {
            $total += $product->getPrice();
        }

        return $total;
    }

    /**
     * Withdraws a product from the cart
     */
    public function removeItem($id) {
        $products = $this->session->get('products', []);
        if ($this->hasItem($id)) {
            unset($products[$id]); // Deletes the product from the cart
        }

        // Updates the session with the tab in the deleted product
        $this->session->set('products', $products);
    }

    /**
     * Clears up the cart
     */
    public function clear() {
        $this->session->set('products', []);
    }
}
