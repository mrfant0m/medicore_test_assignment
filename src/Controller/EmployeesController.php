<?php

namespace App\Controller;

use App\Entity\Employees;
use App\Repository\EmployeesRepository;
use App\Form\EmployeesType;
use App\Service\CalculationService;
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
     * List employees
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
     * Create new employee
     * @Route("/new", name="employees_new", methods={"GET","POST"})
     */
    public function new(Request $request, CalculationService $calculation): Response
    {
        $employee = new Employees();
        $form = $this->createForm(EmployeesType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($employee);
            $entityManager->flush();

            $calculation->employeeCalculation($employee);

            return $this->redirectToRoute('employees_index');
        }

        return $this->render('employees/new.html.twig', [
            'employee' => $employee,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Export
     * @Route("/export", name="employees_export", methods={"GET"})
     */
    public function export(): Response
    {
        $columns = ['Employee', 'Transport', 'Distance', 'Compensation', 'Date'];

        $data = $this->getDoctrine()
                    ->getRepository(Employees::class)
                    ->getExport();

        //put columns header to array
        array_unshift($data, $columns);
        $fp = fopen('php://output', 'w');
        foreach ($data as $row) {
            fputcsv($fp, $row);
        }

        $response = new Response();
        $response->headers->set('Content-Type', 'text/csv');
        //it's gonna output in a export.csv file
        $response->headers->set('Content-Disposition', 'attachment; filename="export.csv"');

        return $response;
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
    public function edit(Request $request, Employees $employee, CalculationService $calculation): Response
    {
        $form = $this->createForm(EmployeesType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $calculation->employeeCalculation($employee);

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
