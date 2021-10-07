<?php

namespace App\Controller;

use App\Entity\Buyer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/reg", name="registration")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createFormBuilder()
            ->add('username')
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],

            ])
            ->add('avatar', FileType::class)
            ->add('register', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success float-left'
                ]
            ])
            ->getForm();
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $data = $form->getData();

            $user = new Buyer();
            $user->setUsername($data['username']);
            $user->setPassword(
                $passwordEncoder->encodePassword($user, $data['password'])
            );
            $user->setRoles(['ROLE_USER']);
            $em = $this->getDoctrine()->getManager();
            dump($request->files);
            $file = $request->files->get('form')['avatar'];
            if ($file)
            {
                $filename = md5(uniqid()) . '.' . $file->guessClientExtension();

                $file->move(
                    $this->getParameter('uploads_dir'),
                    $filename
                );

                $user->setAvatar($filename);
            }
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('app_login'));
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
