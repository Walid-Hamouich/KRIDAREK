<?php

namespace App\Controller;

use App\Service\MinIOManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

class MinIOController extends AbstractController
{
    #[Route('/minio/images/{key}', name: 'app_minio_redirectImage')]
    public function redirectImage(string $key, MinIOManager $minIOManager): Response
    {
        $object = $minIOManager->downloadFile($key);
        if ($object == null) {
            return new NotFoundHttpException('Not found');
        }
        $body = $object->get('Body');
        return new Response(
            $body,
            headers: [
                'Content-Type' => $object->get('Content-Type')
            ]
        );
    }
}
