<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * User controller.
 */
class UserController extends Controller
{
    /**
     * Lists all user entities.
     * 
     * ADMIN
     *
     * @Route("/customers", name="user_customers")
     * @Method("GET")
     */
    public function customersAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')->findAll();

        return $this->render('user/customers.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Register a new user entity.
     * 
     * @Route("/register", name="user_register")
     * @Method({"GET", "POST"})
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('AppBundle\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            // I am doing this here because of my lack of knowledge about 
            // filling fullName column with its own name and surname while 
            // creating given object. Fullname is needed for routes.
            $user->setFullName($user->getName(), $user->getSurname());
            
            $em = $this->getDoctrine()->getManager();            
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_show', array('fullName' => $user->getFullName()));
        }

        return $this->render('user/register.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a user entity.
     * 
     * LOGGED USER
     *
     * @Route("/{fullName}", name="user_show")
     * @Method("GET")
     */
    public function showAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('user/show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     * 
     * LOGGED USER
     *
     * @Route("/{fullName}/edit", name="user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('AppBundle\Form\UserType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_edit', array('fullName' => $user->getFullName()));
        }

        return $this->render('user/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a user entity.
     * 
     * ADMIN
     *
     * @Route("/{fullName}", name="user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('user_customers');
    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param User $user The user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('fullName' => $user->getFullName())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
