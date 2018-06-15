<?php
declare(strict_types=1);

namespace K3ssen\ExtendedGeneratorBundle\Command;

use K3ssen\ExtendedGeneratorBundle\Generator\CrudGenerator;
use K3ssen\GeneratorBundle\Command\Style\CommandStyle;
use K3ssen\ExtendedGeneratorBundle\Generator\CrudGenerateOptions;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CrudCommand extends \K3ssen\GeneratorBundle\Command\CrudCommand
{
    protected static $defaultName = 'generator:crud';

    /** @var CrudGenerateOptions */
    protected $generateOptions;
    /** @var CrudGenerator */
    protected $crudGenerator;

    /**
     * @required
     */
    public function setGenerateOptions(CrudGenerateOptions $generateOptions)
    {
        $this->generateOptions = $generateOptions;
    }

    /**
     * @required
     */
    public function setCrudGenerator(CrudGenerator $crudGenerator)
    {
        $this->crudGenerator = $crudGenerator;
    }

    protected function configure()
    {
        parent::configure();
        $this->addOption('use-datatable', null,InputOption::VALUE_OPTIONAL);
    }

    protected function askCrudQuestions(InputInterface $input, OutputInterface $output)
    {
        parent::askCrudQuestions($input, $output);
        $this->determineUseDatatable($input, $output);
    }

    protected function determineUseDatatable(InputInterface $input, OutputInterface $output)
    {
        $io = new CommandStyle($input, $output);
        $useDatatable = $input->getOption('use-datatable') ?? $this->generateOptions->getUseDatatableDefault();
        if ($this->bundleProvider->isEnabled('SgDatatablesBundle')) {
            if ($this->generateOptions->getAskUseDatatable()) {
                $useDatatable = $io->confirm('Generate Datatable class?', $useDatatable);
            }
        } elseif ($useDatatable) {
            $io->warning('Cannot generate datatable: SgDatatablesBundle is not enabled.');
            $useDatatable = false;
        }
        $this->generateOptions->setUseDatatable($useDatatable);
    }
}
