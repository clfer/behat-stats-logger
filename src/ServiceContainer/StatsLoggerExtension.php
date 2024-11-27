<?php
namespace Genesis\Stats\ServiceContainer;

use Behat\MinkExtension\ServiceContainer\MinkExtension;
use Behat\Testwork\ServiceContainer\Extension as ExtensionInterface;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class StatsLoggerExtension implements ExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigKey()
    {
        return 'behat-stats-logger';
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(ExtensionManager $extensionManager)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function configure(ArrayNodeDefinition $builder): void {
        $builder
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('filePath')
                    ->info('Set where the reports are to be generated.')
                    ->defaultValue('test/report/')
                    ->end()
                ->booleanNode('printToScreen')
                    ->info('Whether to produce console output or not.')
                    ->defaultTrue()
                    ->end()
                ->arrayNode('topReport')
                    ->info('Produce a report of the top steps.')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enabled')
                            ->defaultTrue()
                            ->end()
                        ->integerNode('count')
                            ->info('Number of step summaries to show in the top report.')
                            ->defaultNull()
                            ->end()
                        ->enumNode('sortBy')
                            ->info('Sort the output and file report by metrics.')
                            ->values(['cumulativeTime', 'maxTime', 'count'])
                            ->defaultValue('cumulativeTime')
                            ->end()
                ->end()
                ->arrayNode('suiteReport')
                    ->info('Produce a report of the suites.')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enabled')
                            ->defaultTrue()
                            ->end()
                        ->integerNode('step')
                            ->info('Whether to output step details or not.')
                            ->defaultNull()
                            ->end()
                ->end()
                ->arrayNode('suiteSummary')
                    ->info('Produce a summary of the suites.')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enabled')
                            ->defaultTrue()
                            ->end()
                ->end()
                ->arrayNode('highlight')
                    ->info('For each level (suite, feature, scenario, step) you can define a list of colors with the number of seconds as the limit. Anything above the limit will be highlighted by the color. (Available colors: white | blue | green | brown | yellow | red )')
                    // suite | feature | scenario | step
                    ->useAttributeAsKey('name')
                    ->arrayPrototype()
                        ->children()
                            ->integerNode('red')->end()
                            ->integerNode('yellow')->end()
                            ->integerNode('brown')->end()
                            ->integerNode('green')->end()
                            ->integerNode('blue')->end()
                            ->integerNode('white')->end()
                    ->end()
                ->end()
            ->end();
    }
    /**
     * {@inheritdoc}
     */
    public function load(ContainerBuilder $container, array $config)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
    }
}
