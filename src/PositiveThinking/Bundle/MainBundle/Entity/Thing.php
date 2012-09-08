<?php

namespace PositiveThinking\Bundle\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PositiveThinking\Bundle\MainBundle\Entity\Thing
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Thing
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length="100")
     */
    private $title;

    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="string", length="500")
     */
    private $description;

    /**
     * @var boolean $favoriteDay
     *
     * @ORM\Column(name="favoriteDay", type="boolean")
     */
    private $favoriteDay = false;

    /**
     * @var boolean $favoriteWeek
     *
     * @ORM\Column(name="favoriteWeek", type="boolean")
     */
    private $favoriteWeek = false;

    /**
     * @var boolean $favoriteMonth
     *
     * @ORM\Column(name="favoriteMonth", type="boolean")
     */
    private $favoriteMonth = false;

    /**
     * @var boolean $favoriteYear
     *
     * @ORM\Column(name="favoriteYear", type="boolean")
     */
    private $favoriteYear = false;

    /**
     * @var date $date
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    public function __construct() {
        $this->date          = new \DateTime('today'); 
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param date $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get date
     *
     * @return date 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set title
     *
     * @param title $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return title 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param description $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return description 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set favoriteDay
     *
     * @param favoriteDay $favoriteDay
     */
    public function setFavoriteDay($favoriteDay)
    {
        $this->favoriteDay = $favoriteDay;
    }

    /**
     * Get favoriteDay
     *
     * @return favoriteDay 
     */
    public function isFavoriteDay()
    {
        return $this->favoriteDay;
    }

    /**
     * Set favoriteWeek
     *
     * @param favoriteWeek $favoriteWeek
     */
    public function setFavoriteWeek($favoriteWeek)
    {
        $this->favoriteWeek = $favoriteWeek;
    }

    /**
     * Get favoriteWeek
     *
     * @return favoriteWeek 
     */
    public function isFavoriteWeek()
    {
        return $this->favoriteWeek;
    }

    /**
     * Set favoriteMonth
     *
     * @param favoriteMonth $favoriteMonth
     */
    public function setFavoriteMonth($favoriteMonth)
    {
        $this->favoriteMonth = $favoriteMonth;
    }

    /**
     * Get favoriteMonth
     *
     * @return favoriteMonth 
     */
    public function isFavoriteMonth()
    {
        return $this->favoriteMonth;
    }

    /**
     * Set favoriteYear
     *
     * @param favoriteYear $favoriteYear
     */
    public function setFavoriteYear($favoriteYear)
    {
        $this->favoriteYear = $favoriteYear;
    }

    /**
     * Get favoriteYear
     *
     * @return favoriteYear 
     */
    public function isFavoriteYear()
    {
        return $this->favoriteYear;
    }

    /**
     * Proxy method to set/unset favorites
     * Chain reaction on setting a favorite
     *
     * @param type year, month, week or day
     */
    public function setFavorite ($type)
    {
        switch ($type)
        {
            case 'day':
                $value = !$this->isFavoriteDay();
                $this->setFavoriteDay($value);
                if (!$value)
                {
                    $this->setFavoriteWeek(false);
                    $this->setFavoriteMonth(false);
                    $this->setFavoriteYear(false);
                }
                break;
            case 'week':
                $value = !$this->isFavoriteWeek();
                $this->setFavoriteWeek($value);
                if (!$value)
                {
                    $this->setFavoriteMonth(false);
                    $this->setFavoriteYear(false);
                }
                else
                {
                    $this->setFavoriteDay(true);
                }
                break;
            case 'month':
                $value = !$this->isFavoriteMonth();
                $this->setFavoriteMonth($value);
                if (!$value)
                {
                    $this->setFavoriteYear(false);
                }
                else
                {
                    $this->setFavoriteDay(true);
                    $this->setFavoriteWeek(true);
                }
                break;
            case 'year':
                $value = !$this->isFavoriteYear();
                $this->setFavoriteYear($value);
                if ($value)
                {
                    $this->setFavoriteDay(true);
                    $this->setFavoriteWeek(true);
                    $this->setFavoriteMonth(true);
                }
                break;
        }
    }
}
