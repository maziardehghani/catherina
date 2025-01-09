<?php

namespace DoctrineProxies\__CG__\App\Entities;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Media extends \App\Entities\Media implements \Doctrine\ORM\Proxy\InternalProxy
{
    use \Symfony\Component\VarExporter\LazyGhostTrait {
        initializeLazyObject as private;
        setLazyObjectAsInitialized as public __setInitialized;
        isLazyObjectInitialized as private;
        createLazyGhost as private;
        resetLazyObject as private;
    }

    public function __load(): void
    {
        $this->initializeLazyObject();
    }
    

    private const LAZY_OBJECT_PROPERTY_SCOPES = [
        "\0".parent::class."\0".'createdAt' => [parent::class, 'createdAt', null],
        "\0".parent::class."\0".'id' => [parent::class, 'id', null],
        "\0".parent::class."\0".'mediableId' => [parent::class, 'mediableId', null],
        "\0".parent::class."\0".'mediableType' => [parent::class, 'mediableType', null],
        "\0".parent::class."\0".'name' => [parent::class, 'name', null],
        "\0".parent::class."\0".'type' => [parent::class, 'type', null],
        "\0".parent::class."\0".'updatedAt' => [parent::class, 'updatedAt', null],
        'createdAt' => [parent::class, 'createdAt', null],
        'id' => [parent::class, 'id', null],
        'mediableId' => [parent::class, 'mediableId', null],
        'mediableType' => [parent::class, 'mediableType', null],
        'name' => [parent::class, 'name', null],
        'type' => [parent::class, 'type', null],
        'updatedAt' => [parent::class, 'updatedAt', null],
        'url' => [parent::class, 'url', null],
    ];

    public function __isInitialized(): bool
    {
        return isset($this->lazyObjectState) && $this->isLazyObjectInitialized();
    }

    public function __serialize(): array
    {
        $properties = (array) $this;
        unset($properties["\0" . self::class . "\0lazyObjectState"]);

        return $properties;
    }
}
