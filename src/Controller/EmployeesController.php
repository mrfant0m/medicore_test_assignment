<?php

namespace App\Controller;

use App\Entity\Employees;
use App\Form\EmployeesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/employees")
 */
class EmployeesController extends AbstractController
{
    /**
     * @Route("/", name="employees_index", methods={"GET"})
     */
    public function index(): Response
    {
        $employees = $this->getDoctrine()
            ->getRepository(Employees::class)
            ->findAll();

        return $this->render('employees/index.html.twig', [
            'employees' => $employees,
        ]);
    }

    /**
     * @Route("/new", name="employees_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $employee = new Employees();
        $form = $this->createForm(EmployeesType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($employee);
            $entityManager->flush();

            return $this->redirectToRoute('employees_index');
        }

        return $this->render('employees/new.html.twig', [
            'employee' => $employee,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="employees_show", methods={"GET"})
     */
    public function show(Employees $employee): Response
    {
        return $this->render('employees/show.html.twig', [
            'employee' => $employee,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="employees_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Employees $employee): Response
    {
        $form = $this->createForm(EmployeesType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('employees_index');
        }

        return $this->render('employees/edit.html.twig', [
            'employee' => $employee,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="employees_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Employees $employee): Response
    {
        if ($this->isCsrfTokenValid('delete'.$employee->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($employee);
            $entityManager->flush();
        }

        return $this->redirectToRoute('employees_index');
    }
}
