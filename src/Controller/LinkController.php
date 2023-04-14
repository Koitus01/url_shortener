<?php

namespace App\Controller;

use App\Entity\Link;
use App\Exception\InvalidUrlException;
use App\Form\DatalistType;
use App\Repository\LinkRepository;
use App\UseCase\CreateLink;
use App\ValueObject\Url;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LinkController extends AbstractController
{
	/**
	 * @Route("/", name="app_link_index")
	 */
	public function index(Request $request): Response
	{
		return $this->render( 'index.html.twig' , [
			'error' => $request->get('error', ''),
			'url' => $request->get('url', '')
		]);
	}

	/**
	 * @Route("/link/create", name="app_link_create", methods={"POST", "PUT"})
	 * @throws InvalidUrlException
	 */
	public function create(Request $request, CreateLink $createLink): Response
	{
		$url = Url::fromString($request->get('url'));

		return $this->render( 'index.html.twig' , [
			'error' => $request->get('error', ''),
			'url' => $request->get('url', '')
		]);
	}

	/**
	 * @Route("/link/statistic", name="app_link_statistic")
	 */
	public function statistic(): JsonResponse
	{
		return $this->json( [
			'message' => 'Welcome to your new controller!',
			'path' => 'src/Controller/LinkController.php',
		] );
	}

	/**
	 * «redirect» is better naming, but it's already taken
	 * No separate service, because there isn't much of logic
	 * @param string $hash
	 * @param ManagerRegistry $manager
	 * @return RedirectResponse
	 * @Route("/{hash}", name="app_link_redirect")
	 */
	public function locate( string $hash, ManagerRegistry $manager ): RedirectResponse
	{
		/** @var LinkRepository $repository */
		$repository = $manager->getRepository( Link::class );
		try {
			return $this->redirect( $repository->findAliveOneByHash( $hash )->getUrl()->value() );
		} catch ( EntityNotFoundException $e ) {
			throw $this->createNotFoundException( 'Link is not found or expired' );
		}
	}
}
