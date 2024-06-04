<?php

namespace App\Factory;

use App\Entity\Property;
use App\Enum\ActionEnum;
use App\Enum\TypeEnum;
use App\Repository\PropertyRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Property>
 *
 * @method        Property|Proxy                     create(array|callable $attributes = [])
 * @method static Property|Proxy                     createOne(array $attributes = [])
 * @method static Property|Proxy                     find(object|array|mixed $criteria)
 * @method static Property|Proxy                     findOrCreate(array $attributes)
 * @method static Property|Proxy                     first(string $sortedField = 'id')
 * @method static Property|Proxy                     last(string $sortedField = 'id')
 * @method static Property|Proxy                     random(array $attributes = [])
 * @method static Property|Proxy                     randomOrCreate(array $attributes = [])
 * @method static PropertyRepository|RepositoryProxy repository()
 * @method static Property[]|Proxy[]                 all()
 * @method static Property[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Property[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Property[]|Proxy[]                 findBy(array $attributes)
 * @method static Property[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Property[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class PropertyFactory extends ModelFactory
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
        return [
            'action' => self::faker()->randomElement(ActionEnum::cases()),
            'type' => self::faker()->randomElement(TypeEnum::cases()),
            'city' => CityFactory::new()
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Property $property): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Property::class;
    }
}
