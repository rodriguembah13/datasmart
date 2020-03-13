<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\RolePermission;
use App\Event\PermissionSectionsEvent;
use App\Form\RolePermissionType;
use App\Form\RoleType;
use App\Repository\RolePermissionRepository;
use App\Repository\RoleRepository;
use App\Security\RolePermissionManager;
use App\Security\RoleService;
use App\Util\Model\PermissionSection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/role/permission")
 * @Security("is_granted('role_permissions')")
 */
class RolePermissionController extends AbstractController
{
    /**
     * @var RoleService
     */
    private $roleService;
    /**
     * @var RolePermissionManager
     */
    private $manager;
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    public function __construct(RoleService $roleService, RolePermissionManager $manager, RoleRepository $roleRepository)
    {
        $this->roleService = $roleService;
        $this->manager = $manager;
        $this->roleRepository = $roleRepository;
    }

    /**
     * @Route("/", name="role_permission_index", methods={"GET"})
     */
    public function index(Request $request, EventDispatcherInterface $dispatcher): Response
    {
        $all = $this->roleRepository->findAll();
        $existing = [];

        foreach ($all as $role) {
            $existing[] = $role->getName();
        }

        $existing = array_map('strtoupper', $existing);

        // automatically import all hard coded (default) roles into the database table
        foreach ($this->roleService->getAvailableNames() as $roleName) {
            $roleName = strtoupper($roleName);
            if (!in_array($roleName, $existing)) {
                $role = new Role();
                $role->setName($roleName);
                $this->roleRepository->saveRole($role);
                $existing[] = $roleName;
            }
        }

        // be careful, the order of the search keys is important!
        $permissionOrder = [
            new PermissionSection('User', '_user'),
            new PermissionSection('User profile (own)', '_own_profile'),
            new PermissionSection('User profile (other)', '_other_profile'),
            new PermissionSection('Customer (User)', '_customeruser'),
            new PermissionSection('Customer (Team member)', '_team_customer'),
            new PermissionSection('Customer (Admin)', '_customer'),
            new PermissionSection('Project (Teamlead)', '_teamlead_project'),
            new PermissionSection('Employee (Admin)', '_employee'),
            new PermissionSection('Project (Admin)', '_project'),
            new PermissionSection('Step Project', '_step'),
            new PermissionSection('Timesheet (own)', '_own_timesheet'),
            new PermissionSection('Timesheet (other)', '_other_timesheet'),
            new PermissionSection('Timesheet', '_timesheet'),
            new PermissionSection('Export', '_export'),
            new PermissionSection('Invoice', '_invoice'),
            new PermissionSection('Teams', '_team'),
            new PermissionSection('Tags', '_tag'),
        ];

        $event = new PermissionSectionsEvent();
        foreach ($permissionOrder as $section) {
            $event->addSection($section);
        }
        $dispatcher->dispatch($event);

        $permissionSorted = [];
        $other = [];

        foreach ($event->getSections() as $section) {
            $permissionSorted[$section->getTitle()] = [];
        }

        foreach ($this->manager->getPermissions() as $permission) {
            $found = false;

            foreach ($event->getSections() as $section) {
                if ($section->filter($permission)) {
                    $permissionSorted[$section->getTitle()][] = $permission;
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $other[] = $permission;
            }
        }

        ksort($permissionSorted);

        $permissionSorted['Other'] = $other;

        // order the roles from most powerful to least powerful, custom roles at the end
        $roles = [
            'ROLE_SUPER_ADMIN' => null,
            'ROLE_ADMIN' => null,
            'ROLE_TEAMLEAD' => null,
            'ROLE_USER' => null,
        ];
        foreach ($this->roleRepository->findAll() as $role) {
            $roles[$role->getName()] = $role;
        }
        dump($this->createRoleForm($request));

        return $this->render('role_permission/index.html.twig', [
            'roles' => array_values($roles),
            'permissions' => $this->manager->getPermissions(),
            'sorted' => $permissionSorted,
            'manager' => $this->manager,
            'system_roles' => $this->roleService->getSystemRoles(),
            'form' => $this->createRoleForm($request)->createView(),
        ]);
    }

    private function createRoleForm2(Request $request, Role $role)
    {
        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);

        return $form;
    }

    private function createRoleForm(Request $request)
    {
        $role = new Role();
        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);

        return $form;
    }

    /**
     * @Route("/new/role", name="role_new", methods={"GET","POST"})
     */
    public function newRole(Request $request): Response
    {
        $role = new Role();
        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($role);
            $entityManager->flush();

            return $this->redirectToRoute('role_permission_index');
        }

        return $this->redirectToRoute('role_permission_index');
    }

    /**
     * @Route("/new", name="role_permission_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rolePermission = new RolePermission();
        $form = $this->createForm(RolePermissionType::class, $rolePermission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rolePermission);
            $entityManager->flush();

            return $this->redirectToRoute('role_permission_index');
        }

        return $this->render('role_permission/new.html.twig', [
            'role_permission' => $rolePermission,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="role_permission_show", methods={"GET"})
     */
    public function show(RolePermission $rolePermission): Response
    {
        return $this->render('role_permission/show.html.twig', [
            'role_permission' => $rolePermission,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="role_permission_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RolePermission $rolePermission): Response
    {
        $form = $this->createForm(RolePermissionType::class, $rolePermission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('role_permission_index');
        }

        return $this->render('role_permission/edit.html.twig', [
            'role_permission' => $rolePermission,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="role_permission_delete", methods={"DELETE"})
     * @Security("is_granted('role_permissions')")
     */
    public function delete(Request $request, RolePermission $rolePermission): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rolePermission->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rolePermission);
            $entityManager->flush();
        }

        return $this->redirectToRoute('role_permission_index');
    }

    /**
     * @Route(path="/roles/{id}/{name}/{value}", name="permission_save", methods={"GET"})
     * @Security("is_granted('role_permissions')")
     */
    public function savePermission(Role $role, string $name, string $value, RolePermissionRepository $rolePermissionRepository): Response
    {
        if (!$this->manager->isRegisteredPermission($name)) {
            throw $this->createNotFoundException('Unknown permission: '.$name);
        }

        try {
            $permission = $rolePermissionRepository->findRolePermission($role, $name);
            if (null === $permission) {
                $permission = new RolePermission();
                $permission->setRole($role);
                $permission->setPermission($name);
            }
            $permission->setAllowed((bool) $value);

            $rolePermissionRepository->saveRolePermission($permission);
            $this->addFlash('success', 'enregistrement');
        } catch (\Exception $ex) {
            $this->addFlash('error', 'echec');
        }

        return $this->redirectToRoute('role_permission_index');
    }
}
