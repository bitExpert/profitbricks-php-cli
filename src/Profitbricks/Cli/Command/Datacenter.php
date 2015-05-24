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
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Datacenter command to interact with the profitbricks Datacenter API.
 */
class Datacenter extends Command
{
    /**
     * @var \Profitbricks\Sdk\Client
     */
    protected $client;

    /**
     * Creates a new {\Profitbricks\Command\Datacenter}.
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
        $this->setName('datacenter')
            ->setDescription('Interact with profitbricks datacenters.')
            ->setDefinition(
                array(
                    new InputArgument('subcommand', InputArgument::OPTIONAL, 'The subcommand to execute', 'datacenter')
                )
            );
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $subcommand = $input->getArgument('subcommand');

        switch($subcommand) {
            case 'create':
                $output->writeln('Datacenter Create Command...');
                break;
            case 'read':
                $output->writeln('Datacenter Read Command...');
                break;
            case 'list':
                $datacenters = $this->client->getAllDataCenters();

                if (count($datacenters) > 0) {
                    $table = new Table($output);
                    $table->setStyle('compact');
                    $table->setHeaders(array('ID', 'Datacenter', 'Version'));

                    foreach ($datacenters as $datacenter) {
                        $table->addRow(array($datacenter->getId(), $datacenter->getName(), $datacenter->getVersion()));
                    }

                    $table->render();
                } else {
                    $output->writeln('No datacenters found!');
                }
                break;
            case 'update':
                $output->writeln('Datacenter Update Command...');
                break;
            case 'clear':
                $output->writeln('Datacenter Clear Command...');
                break;
            case 'delete':
                $output->writeln('Datacenter Delete Command...');
                break;
        }
    }
}
