<?php

namespace App\EventListener;

use App\Exception\BusinessLogicException;
use App\Exception\PersistenceException;
use App\Exception\ResourceNotFoundException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ExceptionListener implements EventSubscriberInterface
{
    public function __construct(private LoggerInterface $logger) {}

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::EXCEPTION => 'onKernelException'];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        // Gérer les exceptions personnalisées
        if ($exception instanceof ResourceNotFoundException) {
            $response = new JsonResponse([
                'error' => 'Ressource non trouvée',
                'message' => $exception->getMessage(),
            ], Response::HTTP_NOT_FOUND);
            $event->setResponse($response);
            $this->logger->warning($exception->getMessage());
        } elseif ($exception instanceof BusinessLogicException) {
            $response = new JsonResponse([
                'error' => 'Erreur métier',
                'message' => $exception->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
            $event->setResponse($response);
            $this->logger->warning($exception->getMessage());
        } elseif ($exception instanceof PersistenceException) {
            $response = new JsonResponse([
                'error' => 'Erreur de persistance',
                'message' => $exception->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
            $event->setResponse($response);
            $this->logger->error($exception->getMessage());
        } elseif ($exception instanceof HttpExceptionInterface) {
            // Laisser Symfony gérer les exceptions HTTP standard
            return;
        } else {
            // Exception générique non gérée
            $this->logger->critical('Exception non gérée', ['exception' => $exception]);
            $response = new JsonResponse([
                'error' => 'Une erreur interne est survenue',
                'message' => 'Veuillez contacter l\'administrateur',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
            $event->setResponse($response);
        }
    }
}
