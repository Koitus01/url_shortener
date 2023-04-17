<?php

namespace App\Command;

use App\Repository\LinkRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DeleteExpiredLinksCommand extends Command
{
	private LinkRepository $linkRepository;

	protected static $defaultName = 'app:link:delete_expired';

	public function __construct( LinkRepository $linkRepository )
	{
		$this->linkRepository = $linkRepository;

		parent::__construct();
	}

	protected function configure()
	{
		$this
			->setDescription( 'Mark expired links as deleted' )
			->addOption( 'dry-run', null, InputOption::VALUE_NONE, 'Dry run' );
	}

	protected function execute( InputInterface $input, OutputInterface $output ): int
	{
		$io = new SymfonyStyle( $input, $output );

		$count = $this->linkRepository->deleteExpired();

		$io->success( sprintf( 'Deleted "%d" expired links', $count ) );

		return 0;
	}
}