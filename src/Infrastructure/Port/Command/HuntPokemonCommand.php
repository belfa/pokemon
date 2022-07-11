<?php
declare(strict_types=1);

namespace App\Infrastructure\Port\Command;

use App\Application\Pokedex\PokemonRecord;
use App\Application\Pokemon\Wild\PokemonCatcher;
use App\Application\Sanctuary\SanctuaryReleaser;
use App\Domain\Pokemon\Pokedex\PokedexRepository;
use App\Domain\Pokemon\Sanctuary\SanctuaryRepository;
use App\Domain\Pokemon\Wild\PokemonRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:hunt-pokemon',
    description: 'Hunt pokemon!!!!',
    aliases: ['app:release-pokemon'],
    hidden: false
)]
final class HuntPokemonCommand extends Command
{
    private PokemonCatcher $catcher;
    private PokemonRecord $recorder;
    private SanctuaryReleaser $releaser;

    public function __construct(
        PokemonRepository $pokemonRepository,
        PokedexRepository $pokedexRepository,
        SanctuaryRepository $sanctuaryRepository
    )
    {
        parent::__construct();
        $this->catcher = new PokemonCatcher($pokemonRepository);
        $this->recorder = new PokemonRecord($pokedexRepository);
        $this->releaser = new SanctuaryReleaser($sanctuaryRepository);
    }
    protected function configure(): void
    {
        $this
            ->setHelp('This command allow hunt pokemon.')
            ->addArgument('numberOfPokemon', InputArgument::REQUIRED, 'Number of pokemon to hunt');

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        ini_set('memory_limit', -1);
        $pokemonToHunt = $input->getArgument('numberOfPokemon');

        $output->writeln('Pokemon to hunt: ' . $pokemonToHunt);
        $progressBar = new ProgressBar($output, (int)$pokemonToHunt);

        for ($i = 1; $i <= $pokemonToHunt; $i++) {
            $pokemonId = rand(1, 905);
            $pokemon = $this->catcher->catch($pokemonId);
            $this->recorder->record($pokemon);
            $this->releaser->release($pokemon);
            $progressBar->advance();
        }
        $progressBar->finish();
        $output->writeln(PHP_EOL);
        return Command::SUCCESS;
    }
}