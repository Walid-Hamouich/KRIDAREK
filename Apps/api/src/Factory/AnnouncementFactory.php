<?php

namespace App\Factory;

use App\Entity\Announcement;
use App\Enum\StatusEnum;
use App\Repository\AnnouncementRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Announcement>
 *
 * @method        Announcement|Proxy                     create(array|callable $attributes = [])
 * @method static Announcement|Proxy                     createOne(array $attributes = [])
 * @method static Announcement|Proxy                     find(object|array|mixed $criteria)
 * @method static Announcement|Proxy                     findOrCreate(array $attributes)
 * @method static Announcement|Proxy                     first(string $sortedField = 'id')
 * @method static Announcement|Proxy                     last(string $sortedField = 'id')
 * @method static Announcement|Proxy                     random(array $attributes = [])
 * @method static Announcement|Proxy                     randomOrCreate(array $attributes = [])
 * @method static AnnouncementRepository|RepositoryProxy repository()
 * @method static Announcement[]|Proxy[]                 all()
 * @method static Announcement[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Announcement[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Announcement[]|Proxy[]                 findBy(array $attributes)
 * @method static Announcement[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Announcement[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class AnnouncementFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        $images =  [];
        for ($i = 0; $i < rand(1, 5); $i++) {
            $images[] = 'https://picsum.photos/200/300?random=' . rand(1, 999);
        }

        return [
            'contactPhone' => self::faker()->phoneNumber(),
            'description' => self::faker()->text(255),
            'images' => $images,
            'available' => self::faker()->boolean(),
            'sponsored' => self::faker()->boolean(),
            'price' => self::faker()->randomFloat(2, 10000, 99999),
            'publishedBy' => UserFactory::new(),
            'sponsorDate' => self::faker()->dateTime(),
            'sponsorDuration' => self::faker()->randomNumber(),
            'area' => self::faker()->numberBetween(10, 300),
            'status' => self::faker()->randomElement(StatusEnum::cases()),
            'title' => self::faker()->word(3, 4),
            'bookmarkers' => UserFactory::createMany(2),
            'property' => PropertyFactory::createOne()
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Announcement $announcement): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Announcement::class;
    }
}
