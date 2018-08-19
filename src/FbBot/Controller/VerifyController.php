<?php
declare(strict_types=1);

/**
 * PHP version 7.1.17
 * This file is part of ChatBot project.
 *
 * @author  Peter Simoncic <alulord@gmail.com>
 * @license GNU AGPLv3
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChatBot\FbBot\Controller;

use DI\DependencyException;
use DI\NotFoundException;
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
     * @throws DependencyException
     * @throws NotFoundException
     * @return Response
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

    /**
     * This is here just because fb check if policies page is working
     *
     * @return Response
     */
    public function policiesAction(): Response
    {
        $content = <<<'TAG'
 <!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
</head>
<body>

<h1>My First Heading</h1>
<p>My first paragraph.</p>

</body>
</html> 
TAG;

        return new Response($content);
    }
}
