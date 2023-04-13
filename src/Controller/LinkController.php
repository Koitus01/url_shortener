<?php

namespace App\Controller;

use App\Entity\Link;
use App\Repository\LinkRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class LinkController extends AbstractController
{
	/**
	 * @Route("/", name="app_index")
	 */
	public function index(): JsonResponse
	{
		return $this->json( [
			'message' => 'Welcome to your new controller!',
			'path' => 'src/Controller/LinkController.php',
		] );
	}

	/**
	 * @Route("/link/statistics", name="app_link")
	 */
	public function list(): JsonResponse
	{
		return $this->json( [
			'message' => 'Welcome to your new controller!',
			'path' => 'src/Controller/LinkController.php',
		] );
	}

	/**
	 * «redirect» is better naming, but it's already taken
	 * Logic is here, because there isn't much of it
	 * @param string $hash
	 * @param ManagerRegistry $manager
	 * @return RedirectResponse
	 * @Route("/{hash}", name="app_redirect")
	 */
	public function locate( string $hash, ManagerRegistry $manager ): RedirectResponse
	{
		/** @var LinkRepository $repository */
		$repository = $manager->getRepository( Link::class );
		try {
			return $this->redirect( $repository->findOneBy([
				'hash' => $hash,
			]) );
		} catch ( EntityNotFoundException $e ) {
			throw $this->createNotFoundException('Link is not found or expired');
		}
	}
}
