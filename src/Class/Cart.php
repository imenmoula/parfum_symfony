<?php
namespace src\Class;


use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class Cart
{
    // private $seesion;
    // public  function __construct(SessionInterface $session)
    // {
    //     $this->seesion = $session;
    // }

    // public function add(int $id)
    // {
    //     $cartData = $this->session->get('cart', []);
    //     $newCartData = $cartData;

    //     if (!empty($cartData[$id])) {
    //         $newCartData[$id]++;
    //     } else {
    //         $newCartData[$id] = 1;
    //     }
    //     $this->session->set('cart', $newCartData);
    // }
    // public function get(){
    //     return $this->session->get('cart');

    // }

    // public function remove(){
    //     return $this->session->remove('cart');

    // }


}
?>
