<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use src\Class\Cart;
use App\Entity\Parfum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\ParfumRepository;
#[Route('/cart', name: 'cart_')]
class CartController extends AbstractController
{
    #[Route('/cart', name: 'index1')]
    public function Cartindex(SessionInterface $session, ParfumRepository $parfumRepository)
{
    $panier = $session->get('panier', []);
    $data = [];
    $total = 0;

    foreach ($panier as $id => $quantite) {
        $parfum = $parfumRepository->find($id);
        
        if ($parfum !== null) {
            $data[] = [
                'parfum' => $parfum,
                'quantite' => $quantite
            ];

            if ($parfum->getPrix() !== null) {
                $total += $parfum->getPrix() * $quantite;
            } else {
                error_log('Error: getPrix() returned null for Parfum with ID ' . $id);
            }
        } else {
            error_log('Error: Parfum with ID ' . $id . ' not found');
        }
    }

    return $this->render('cart/index.html.twig', compact('data', 'total'));
}

    #[Route('/add/{id}', name: 'add')]
    public function  add(Parfum $parfum,SessionInterface $session)
    {
        $id=$parfum->getId();
        $panier=$session->get('panier',[]);
        if(empty($panier[$id])){
            $panier[$id]=1;
        }
        else{
            $panier[$id]++;
        }
        $session->set('panier', $panier);
        return $this->redirectToRoute('cart_index1');

    }
    #[Route('/remove/{id}', name: 'remove')]
    public function  remove(Parfum $parfum,SessionInterface $session)
    {
        $id=$parfum->getId();
        $panier=$session->get('panier',[]);
        if($panier[$id]>1){
            $panier[$id]--;
        }
        else{
            unset($panier[$id]);
        }
        $session->set('panier', $panier);
        return $this->redirectToRoute('cart_index1');

    }
    #[Route('/delete/{id}', name: 'delete')]
    public function  delete(Parfum $parfum,SessionInterface $session)
    {
        $id=$parfum->getId();
        $panier=$session->get('panier',[]);
        if(!empty($panier[$id])){
           unset($panier[$id]);
        }
        
        $session->set('panier', $panier);
        return $this->redirectToRoute('cart_index1');

    }
   /* #[Route('/empty/{id}', name: 'empty')]
    public function  delete(SessionInterface $session)
    {
        $session->remove('panier');
        return $this->redirectToRoute('cart_index');
        
    }*/
}
?>