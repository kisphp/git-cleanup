<?php

namespace Kisphp\Command;

use Cilex\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class ClearBranchesCommand extends Command
{
    /**
     * @var array
     */
    protected $protectedBranches = [
        'develop',
        'master',
    ];

    /**
     * @var array
     */
    protected $localBranches = [];

    /**
     * @var array
     */
    protected $remoteBranches = [];

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName('clean:branches')
            ->setDescription('Remove merged branches')
            ->addOption(
                'force',
                'f',
                InputOption::VALUE_NONE,
                'Execute the branch removal'
            )
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->gitFetch($output);
        $this->getLocalBranches($output);
        $this->getRemoveBranches($output);

        $this->runCommand($input, $output);
    }

    /**
     * @param string $branch
     *
     * @return bool
     */
    protected function displayOrExecute(InputInterface $input, OutputInterface $output, $branch)
    {
        $command = 'git branch -D %s';

        if ($input->getOption('force')) {
            $output->write('<question>Executing</question>: ');
            $process = new Process(sprintf($command, $branch));
            $process->mustRun();
        }

        $output->writeln(sprintf($command, '<info>' . $branch . '</info>'));

        return true;
    }

    /**
     * @param OutputInterface $output
     */
    private function gitFetch(OutputInterface $output)
    {
        $output->writeln('<comment>Git fetch</comment>');

        $process = new Process('git fetch -p');
        $process->run();

        $output->writeln($process->getOutput());
    }

    /**
     * @param OutputInterface $output
     */
    private function getLocalBranches(OutputInterface $output)
    {
        $process = new Process('git branch');
        $process->run();
        $localBranches = explode("\n", $process->getOutput());

        $this->localBranches = $this->filterBranches($localBranches);
    }

    /**
     * @param OutputInterface $output
     */
    private function getRemoveBranches(OutputInterface $output)
    {
        $process = new Process('git branch -r');
        $process->run();
        $localBranches = explode("\n", $process->getOutput());

        $this->remoteBranches = $this->filterBranches($localBranches);
    }

    /**
     * @param array $branches
     * @param bool|false $isRemote
     *
     * @return array
     */
    private function filterBranches(array $branches, $isRemote = false)
    {
        $filteredBranches = [];
        foreach ($branches as $branch) {
            if (!$isRemote && preg_match('/\*/', $branch)) {
                continue;
            }

            if (!$isRemote && in_array(trim($branch), $this->protectedBranches)) {
                continue;
            }

            $branchName = str_replace('origin/', '', trim($branch));

            if (empty($branchName)) {
                continue;
            }

            $filteredBranches[] = $branchName;
        }

        return $filteredBranches;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return bool
     */
    public function runCommand(InputInterface $input, OutputInterface $output)
    {
        $branchesToRemove = [];
        foreach ($this->localBranches as $localBranch) {
            if (!in_array($localBranch, $this->remoteBranches)) {
                $branchesToRemove[] = $localBranch;
            }
        }
        if (count($branchesToRemove) < 1) {
            $output->writeln('<info>No orphan branches! Well done!</info>');

            return true;
        }

        $output->writeln('<comment>Branches to remove</comment>');
        foreach ($branchesToRemove as $branch) {
            $this->displayOrExecute($input, $output, $branch);
        }

        return true;
    }
}
