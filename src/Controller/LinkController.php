<?php

namespace App\Controller;

use App\Entity\Link;
use App\Exception\InvalidUrlException;
use App\Exception\UrlHashGenerateException;
use App\Repository\LinkRepository;
use App\Service\Interfaces\ExceptionLoggerInterface;
use App\UseCase\CreateLink;
use App\UseCase\UpdateStatistic;
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
	public function index( Request $request ): Response
	{
		return $this->render( 'index.html.twig', [
			'error' => $request->get( 'error', '' ),
			'url' => $request->get( 'url', '' )
		] );
	}

	/**
	 * @Route("/link/create", name="app_link_create", methods={"POST", "PUT"})
	 */
	public function create( Request $request, CreateLink $createLink , ExceptionLoggerInterface $exceptionLogger): Response
	{
		$inputUrl = $request->get( 'url' );
		try {
			$url = Url::fromString( $inputUrl );
			$createLink->execute( $url );
		} catch ( InvalidUrlException $e ) {
			$this->redirect($this->generateUrl('app_link_index', [
				'error' => $request->get( 'error', $e->getMessage() ),
				'url' => $request->get( 'url', $inputUrl )
			]));
		} catch ( UrlHashGenerateException $e ) {
			$this->render('error.html.twig');
		}


		return $this->render( 'index.html.twig', [
			'error' => $request->get( 'error', '' ),
			'url' => $request->get( 'url', '' )
		] );
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
	 * @param ManagerRegistry $doctrine
	 * @param UpdateStatistic $updateStatistic
	 * @return RedirectResponse
	 * @Route("/{hash}", name="app_link_redirect")
	 */
	public function locate( string $hash, ManagerRegistry $doctrine, UpdateStatistic $updateStatistic): RedirectResponse
	{
		/** @var LinkRepository $repository */
		$repository = $doctrine->getRepository( Link::class );
		try {
			$linkEntity = $repository->findAliveOneByHash( $hash );
			$updateStatistic->execute($linkEntity);
			return $this->redirect( $linkEntity->getUrl()->value() );
		} catch ( EntityNotFoundException $e ) {
			throw $this->createNotFoundException( 'Link is not found or expired' );
		}
	}
}
