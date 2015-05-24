<?php

/*
 * This file is part of the Profitbricks CLI tool.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Profitbricks\Cli\Command;

use Profitbricks\Sdk\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * ListSnapshots command to interact with the profitbricks Snapshots API.
 */
class ListSnapshots extends Command
{
    /**
     * @var \Profitbricks\Sdk\Client
     */
    protected $client;

    /**
     * Creates a new {\Profitbricks\Command\ListSnapshots}.
     *
     * @param \Profitbricks\Sdk\Client $client
     */
    public function __construct(Client $client)
    {
        parent::__construct();

        $this->client = $client;
    }

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this->setName('snapshots')
            ->setDescription('Returns the list of all snapshots.');
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $snapshots = $this->client->getAllSnapshots();

        if (count($snapshots) > 0) {
            $table = new Table($output);
            $table->setStyle('compact');
            $table->setHeaders(array('ID', 'Snapshot', 'Size'));

            foreach ($snapshots as $snapshot) {
                $table->addRow(array($snapshot->getId(), $snapshot->getName(), $snapshot->getSize()));
            }

            $table->render();
        } else {
            $output->writeln('No snapshots found!');
        }
    }
}
