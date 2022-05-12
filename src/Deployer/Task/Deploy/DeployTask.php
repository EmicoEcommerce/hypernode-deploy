<?php

namespace Hypernode\Deploy\Deployer\Task\Deploy;

use Hypernode\DeployConfiguration\ServerRole;
use function Deployer\fail;
use function Deployer\task;
use Hypernode\Deploy\Deployer\RecipeLoader;
use Hypernode\Deploy\Deployer\Task\TaskInterface;
use Hypernode\DeployConfiguration\Configuration;

class DeployTask implements TaskInterface
{
    /**
     * @var RecipeLoader
     */
    private $loader;

    /**
     * DeployTask constructor.
     *
     * @param RecipeLoader $loader
     */
    public function __construct(RecipeLoader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Configure using hipex configuration
     *
     * @param Configuration $config
     */
    public function configure(Configuration $config)
    {
        $this->loader->load('deploy/info.php');

        task('deploy', [
            'deploy:upload',
            'deploy:link',
            'deploy:finalize',
        ])->onRoles(ServerRole::APPLICATION);

        fail('deploy', 'deploy:failed');
    }
}