<?php
declare(strict_types=1);

namespace Zam\Cli\Console\Command;

use Magento\Framework\Console\Cli;
use Magento\Framework\Module\ModuleList;
use Magento\Setup\Model\ObjectManagerProvider;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CheckActive extends Command
{
    const NAME_ARGUMENT = "name";
    const NAME_OPTION = "option";

    /**
     * @var OutputInterface $output
     */
    protected $output;

    /**
     * Object manager provider
     *
     * @var ObjectManagerProvider
     */
    private $objectManager;

    /**
     * {@inheritdoc}
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $this->objectManager = $objectManager;

        $name = $input->getArgument(self::NAME_ARGUMENT);
        $option = $input->getOption(self::NAME_OPTION);
        $output->writeln("list of all active modules");
        $this->output = $output;
        return $this->listModules();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName("check-active");
        $this->setDescription("Display a list of all active modules");
        $this->setDefinition([
            new InputArgument(self::NAME_ARGUMENT, InputArgument::OPTIONAL, "Name"),
            new InputOption(self::NAME_OPTION, "-a", InputOption::VALUE_NONE, "Option functionality")
        ]);
        parent::configure();
    }

    /**
     * @return int
     */
    private function listModules()
    {
        $enabledModules = $this->objectManager->create(ModuleList::class);
//        die("ok");
        $enabledModuleNames = $enabledModules->getNames();
        if (count($enabledModuleNames) === 0) {
            $this->output->writeln('None');
            return Cli::RETURN_FAILURE;
        }

        $this->output->writeln(join("\n", $enabledModuleNames));
        return \Magento\Framework\Console\Cli::RETURN_SUCCESS;
    }
}
