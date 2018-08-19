<?php
declare(strict_types=1);

namespace ChatBot\FbBot\Controller;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class VerifyController
 *
 * @package ChatBot\FbBot\Controller
 *
 * @author Peter Simoncic <peter.simoncic@smeonline.sk>
 */
class VerifyController extends AbstractController
{

    /**
     *
     * @param Request $request
     *
     * @return Response
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function verifyAction(Request $request): Response
    {
        $hubVerifyToken = null;
        if (false === $request->query->has('hub_challenge')) {
            throw new \LogicException('You must send challenge');
        }
        $challenge = $request->query->get('hub_challenge');
        $hubVerifyToken = $request->query->get('hub_verify_token');
        $verifyToken = $this->container->get('%verify_token%');
        if ($hubVerifyToken !== $verifyToken) {
            throw new InvalidArgumentException('Bad verification token');
        }

        return new Response($challenge);
    }

}