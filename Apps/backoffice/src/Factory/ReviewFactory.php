<?php

namespace App\Factory;

use App\Entity\Review;
use App\Repository\ReviewRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Review>
 *
 * @method        Review|Proxy                     create(array|callable $attributes = [])
 * @method static Review|Proxy                     createOne(array $attributes = [])
 * @method static Review|Proxy                     find(object|array|mixed $criteria)
 * @method static Review|Proxy                     findOrCreate(array $attributes)
 * @method static Review|Proxy                     first(string $sortedField = 'id')
 * @method static Review|Proxy                     last(string $sortedField = 'id')
 * @method static Review|Proxy                     random(array $attributes = [])
 * @method static Review|Proxy                     randomOrCreate(array $attributes = [])
 * @method static ReviewRepository|RepositoryProxy repository()
 * @method static Review[]|Proxy[]                 all()
 * @method static Review[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Review[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Review[]|Proxy[]                 findBy(array $attributes)
 * @method static Review[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Review[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class ReviewFactory extends ModelFactory
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
            'dateReview' => self::faker()->dateTime(),
            'description' => self::faker()->paragraph(),
            'evaluation' => self::faker()->numberBetween(1, 5),
            'user' => UserFactory::new(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Review $reviews): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Review::class;
    }
}
