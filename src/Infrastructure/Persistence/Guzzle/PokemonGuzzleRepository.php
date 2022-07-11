<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Guzzle;

use App\Domain\Pokemon\Wild\HeldItem;
use App\Domain\Pokemon\Wild\HeldItemDetail;
use App\Domain\Pokemon\Wild\HeldItemDetailCollection;
use App\Domain\Pokemon\Wild\Pokemon;
use App\Domain\Pokemon\Wild\PokemonRepository;
use App\Domain\Pokemon\Wild\Sprite;
use App\Domain\Pokemon\Wild\Type;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

final class PokemonGuzzleRepository implements PokemonRepository
{
    private Client $client;
    private const URI = 'https://pokeapi.co/api/v2/pokemon/';

    public function __construct()
    {
        $this->client = new Client(
            [
                'base_uri' => self::URI
            ]
        );
    }

    public function catch(int $id): ?Pokemon
    {
        try {
            $uri = self::URI . $id;

            $response = $this->client->get($uri);

            if ($response->getStatusCode() !== 200) {
                return null;
            }

            $info = json_decode($response->getBody()->getContents(), true);

            $pokemon = Pokemon::catchUp(
                $info['id'],
                $info['name'],
                gettimeofday(true)
            );

            foreach ($info['types'] as $rawSpecie) {
                $pokemon->addType(
                    Type::classify(
                        $rawSpecie['type']['name'],
                        $rawSpecie['type']['url']
                    )
                );
            }

            foreach ($info['sprites'] as $url) {
                if (!is_string($url)) {
                    continue;
                }
                $pokemon->addSprite(
                    Sprite::draw($url)
                );
            }

            foreach ($info['held_items'] as $heldItem) {
                $details = new HeldItemDetailCollection();
                foreach ($heldItem['version_details'] as $detail) {
                    $details->add(
                        HeldItemDetail::with(
                            $detail['rarity'],
                            $detail['version']['name'],
                            $detail['version']['url']
                        )
                    );
                }
                $pokemon->addHeldItem(
                    HeldItem::attach(
                        $heldItem['item']['name'],
                        $heldItem['item']['url'],
                        $details
                    )
                );
            }

            return $pokemon;
        } catch (GuzzleException) {
            return null;
        }
    }
}