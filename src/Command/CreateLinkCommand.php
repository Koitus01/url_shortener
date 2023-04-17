<?php

namespace App\Command;

use App\UseCase\CreateLink;
use App\ValueObject\Url;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CreateLinkCommand extends Command
{

	protected static $defaultName = 'app:link:create';
	private CreateLink $createLink;
	private ParameterBagInterface $params;

	public function __construct( CreateLink $createLink, ParameterBagInterface $params )
	{
		$this->createLink = $createLink;
		$this->params = $params;

		parent::__construct();
	}

	protected function configure()
	{
		$this
			->setDescription( 'Create short URL' )
			->addArgument( 'url', InputArgument::REQUIRED, 'The URL for shortening' );
	}

	protected function execute( InputInterface $input, OutputInterface $output ): int
	{
		$io = new SymfonyStyle( $input, $output );
		$url = $input->getArgument( 'url' );
		try {
			$result = $this->createLink->execute( Url::fromString( $url ) );
		} catch ( \Throwable $e ) {
			$io->error( sprintf( 'Cannot create shor url because of error: ' . $e->getMessage() ) );
			return 0;
		}

		$shortUrl = $this->params->get( 'app.url' ) . $result->getHash();
		$io->success( 'Shor url: ' . $shortUrl );
		return 0;
	}
}