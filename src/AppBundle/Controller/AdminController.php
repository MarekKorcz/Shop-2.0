<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Service\FileUploader;

/**
 * Admin controller.
 *
 * @Route("admin")
 */
class AdminController extends Controller
{    
    /**
     * Creates a new product entity.
     * 
     * @Route("/product/new", name="product_new")
     * @Method({"GET", "POST"})
     */
    public function newProductAction(Request $request, FileUploader $fileUploader)
    {
        $product = new Product();
        $form = $this->createForm('AppBundle\Form\ProductType', $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $picture = $product->getPicture();
            
            $pictureName = $fileUploader->upload($picture);
            
            $product->setPicture($pictureName);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('product_show', array('nameUrl' => $product->getNameUrl()));
        }

        return $this->render('product/new.html.twig', array(
            'product' => $product,
            'form' => $form->createView(),
        ));
    }
    
    /**
     * @return string
     */
    private function generateUniquePictureName() {
        
        return md5(uniqid());
    }

    /**
     * Displays a form to edit an existing product entity.
     * 
     * @Route("/product/{nameUrl}/edit", name="product_edit")
     * @Method({"GET", "POST"})
     */
    public function editProductAction(Request $request, Product $product)
    {
        $deleteForm = $this->createProductDeleteForm($product);
        $editForm = $this->createForm('AppBundle\Form\ProductType', $product);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_edit', array('nameUrl' => $product->getNameUrl()));
        }

        return $this->render('product/edit.html.twig', array(
            'product' => $product,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    /**
     * Lists of all product entities.
     * 
     * @Route("/product/list", name="product_list")
     * @Method("GET")
     */
    public function listProductsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('AppBundle:Product')->findAll();

        return $this->render('product/list.html.twig', array(
            'products' => $products,
        ));
    }
    
    /**
     * Deletes a product entity.
     *
     * @Route("/product/{nameUrl}", name="product_delete")
     * @Method("DELETE")
     */
    public function deleteProductAction(Request $request, Product $product)
    {
        $form = $this->createProductDeleteForm($product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
        }

        return $this->redirectToRoute('product_list');
    }
    
    /**
     * Creates a form to delete a product entity.
     *
     * @param Product $product The product entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createProductDeleteForm(Product $product)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('product_delete', array('nameUrl' => $product->getNameUrl())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    
    
    /**
     * Creates a new category entity.
     * 
     * @Route("/category/new", name="category_new")
     * @Method({"GET", "POST"})
     */
    public function newCategoryAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm('AppBundle\Form\CategoryType', $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('category_show', array('nameUrl' => $category->getNameUrl()));
        }

        return $this->render('category/new.html.twig', array(
            'category' => $category,
            'form' => $form->createView(),
        ));
    }
    
    /**
     * Displays a form to edit an existing category entity.
     * 
     * @Route("/category/{nameUrl}/edit", name="category_edit")
     * @Method({"GET", "POST"})
     */
    public function editCategoryAction(Request $request, Category $category)
    {
        $deleteForm = $this->createCategoryDeleteForm($category);
        $editForm = $this->createForm('AppBundle\Form\CategoryType', $category);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('category_edit', array('nameUrl' => $category->getNameUrl()));
        }

        return $this->render('category/edit.html.twig', array(
            'category' => $category,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    /**
     * Lists all category entities.
     *
     * @Route("/category/list", name="category_list")
     * @Method("GET")
     */
    public function categoriesListAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('AppBundle:Category')->findAll();

        return $this->render('category/list.html.twig', array(
            'categories' => $categories,
        ));
    }
    
    /**
     * Deletes a category entity.
     * 
     * @Route("/category/{nameUrl}", name="category_delete")
     * @Method("DELETE")
     */
    public function deleteCategoryAction(Request $request, Category $category)
    {
        $form = $this->createCategoryDeleteForm($category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush();
        }

        return $this->redirectToRoute('category_list');
    }    
    
    /**
     * Creates a form to delete a category entity.
     *
     * @param Category $category The category entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCategoryDeleteForm(Category $category)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('category_delete', array('nameUrl' => $category->getNameUrl())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    
    
    /**
     * Lists all users.
     *
     * @Route("/customers", name="customers")
     * @Method("GET")
     */
    public function customersAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')->findAll();

        return $this->render('admin/customers.html.twig', array(
            'users' => $users,
        ));
    }
}