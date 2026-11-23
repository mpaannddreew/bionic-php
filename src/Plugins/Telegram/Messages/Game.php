<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Telegram\Messages;


use Andre\Bionic\AbstractMessage;
use Andre\Bionic\Plugins\Telegram\MessageEntity;
use Andre\Bionic\Plugins\Telegram\PhotoSize;

class Game extends AbstractMessage
{
    /**
     * @var string $title
     */
    protected $title;

    /**
     * @var string $description
     */
    protected $description;

    /**
     * @var array $photo
     */
    protected $photo = [];

    /**
     * @var string
     */
    protected $text;
    /**
     * @var array $text_entities
     */
    protected $text_entities = [];

    /**
     * @var array $animation
     */
    protected $animation = [];

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return array
     */
    public function getPhoto()
    {
        if ($this->photo) {
            $photo = [];
            foreach ($this->photo as $item) {
                array_push($photo, PhotoSize::create($item));
            }
        }

        return null;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return array
     */
    public function getTextEntities()
    {
        if ($this->text_entities) {
            $entities = [];
            foreach ($this->text_entities as $entity) {
                array_push($entities, MessageEntity::create($entity));
            }

            return $entities;
        }

        return null;
    }

    /**
     * @return Animation
     */
    public function getAnimation()
    {
        if ($this->animation) {
            return Animation::create($this->animation);
        }

        return null;
    }
}