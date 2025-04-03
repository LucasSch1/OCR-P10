<?php

namespace App\Controller;

use App\Entity\Employe;
use Doctrine\ORM\EntityManagerInterface;
use Endroid\QrCode\QrCode;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Google\GoogleAuthenticatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;


class TwoFactorController extends AbstractController
{
    #[Route('/2fa/setup', name: 'app_2fa_setup')]
    public function setup2fa(
        GoogleAuthenticatorInterface $googleAuthenticator,
        EntityManagerInterface $em,
        TokenStorageInterface $tokenStorage
    ) {
        /** @var Employe $user */
        $user = $tokenStorage->getToken()->getUser();

        if (!$user->isGoogleAuthenticatorEnabled()) {
            $secret = $googleAuthenticator->generateSecret();
            $user->setGoogleAuthenticatorSecret($secret);
            $em->flush();
        }

        $qrCodeContent = $googleAuthenticator->getQRContent($user);


        $qrCode = new QrCode($qrCodeContent);

        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        $qrImageBase64 = base64_encode($result->getString());

        return $this->render('security/2fa_setup.html.twig', [
            'qrImage' => $qrImageBase64,
        ]);
    }
}
