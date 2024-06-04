<?php

namespace App\Controller;

use App\Entity\User;
use App\Enum\RoleEnum;
use App\Form\Type\AddUserAccountType;
use App\Form\Type\EditUserAccountType;
use App\Service\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(('ROLE_ADMIN'))]
#[Route('/users')]
class UsersController extends AbstractController
{
    public function __construct(
        private UserManager $userManager,
    ) {
    }

    #[Route('', name: 'app_users_index')]
    public function index(): Response
    {
        /**
         * @var User
         */
        $currentUser = $this->getUser();

        if (in_array(RoleEnum::SUPER_ADMIN->value, $currentUser->getRoles())) :
            $users = $this->userManager->findAll();
        elseif (in_array(RoleEnum::ADMIN->value, $currentUser->getRoles())) :
            $users = $this->userManager->findAllForAdmin();
        endif;

        return $this->render('users/index.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/add', name: 'app_users_add', methods: ['GET', 'POST'])]
    public function add(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(AddUserAccountType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->userManager->add($user);
            $this->addFlash('success', "L'utilisateur a été ajouté avec succés!");
            return $this->redirectToRoute('app_users_index');
        }
        return $this->render('users/add.html.twig', [
            'form' => $form
        ]);
    }

    #[IsGranted('ROLE_SUPER_ADMIN')]
    #[Route('/edit/{id}', requirements: ['id' => '\d+'], name: 'app_users_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, int $id)
    {
        /**
         * @var User
         */
        $currentUser = $this->getUser();
        $user = $this->userManager->find($id);
        if ($user == null || $currentUser->getId() === $user->getId())
            return $this->redirectToRoute('app_users_index');
        $form = $this->createForm(EditUserAccountType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->userManager->update($user);
            $this->addFlash('success', "L'utilisateur a été modifié avec succés!");
            return $this->redirectToRoute('app_users_index');
        }
        return $this->render('users/edit.html.twig', [
            'form' => $form
        ]);
    }

    #[IsGranted('ROLE_SUPER_ADMIN')]
    #[Route('/{id}', name: 'app_users_remove', methods: ['DELETE'])]
    public function remove(User $user,): Response
    {
        $this->userManager->remove($user);
        $this->addFlash('success', "L'utilisateur a été supprimé avec succés!");
        return $this->redirectToRoute('app_users_index');
    }

    #[Route('/ban/{id}', requirements: ['id' => '\d+'], methods: ['PUT'])]
    public function ban(int $id): Response
    {
        $user = $this->userManager->find($id);
        if (!$this->isAbleToBanOrUnban($user)) return $this->redirectToRoute('app_users_index');
        $this->userManager->ban($user);
        $this->addFlash('success', "L'utilisateur a été ajouté à la liste noire");
        return $this->redirectToRoute('app_users_index');
    }

    #[Route('/unban/{id}', requirements: ['id' => '\d+'], methods: ['PUT'])]
    public function unban(int $id): Response
    {
        $user = $this->userManager->find($id);
        if (!$this->isAbleToBanOrUnban($user)) return $this->redirectToRoute('app_users_index');
        $this->userManager->unban($user);
        $this->addFlash('success', "L'utilisateur a été supprimé de la liste noire");
        return $this->redirectToRoute('app_users_index');
    }

    function isAbleToBanOrUnban(User $user): bool
    {
        /**
         * @var User
         */
        $currentUser = $this->getUser();
        if ($user === null || $currentUser->getId() === $user->getId() || in_array(RoleEnum::SUPER_ADMIN, $user->getRoles(), true))
            return false;

        if (
            !in_array(RoleEnum::SUPER_ADMIN->value, $currentUser->getRoles(), true) &&
            in_array(RoleEnum::ADMIN->value, $user->getRoles(), true)
        ) {
            return false;
        }
        return true;
    }
}
