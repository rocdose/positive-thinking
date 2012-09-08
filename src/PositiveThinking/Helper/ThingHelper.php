<?php

namespace PositiveThinking\Helper;

class ThingHelper
{
    private $entityManager;

    public function __construct($entityManager) 
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Get things within a range of dates
     * Defaults to today's date if invalid/empty date
     *
     * @param range Type of range: day, week, month, year
     * @param date  date
     * @param favorites Favorite things of the range only 
     *
     * @return Associative of Things ordered by date
     */
    public function getThings ($range, $date = "", $favorites = false)
    {
        $things = array();
        $range = strtolower($range);
        if (!$this->isValidDate($date))
        {
            $date = date('d-m-Y');
        }
        $date = strtotime($date);

        switch ($range)
        {
            case 'day':
                $things = $this->getDayThings($date, $favorites);
                break;
            case 'week':
                $things = $this->getWeekThings($date, $favorites);
                break;
            case 'month':
                $things = $this->getMonthThings($date, $favorites);
                break;
            case 'year':
                $things = $this->getYearThings($date, $favorites);
                break;
            default:
                return $things;
                break;
        }

        $orderedThings = array();
        foreach ($things as $thing)
        {
            $orderedThings[$thing->getDate()->getTimestamp()][] = $thing;
        }

        return $orderedThings;
    }

    /**
     * Proxy method to get things tag as favorite (day, week, month, year)
     *
     * @param range Range in day, week, month, year
     *
     */
    public function getFavoriteThings ($range)
    {
        return $this->getThings($range, date('d-m-Y'), true);
    }

    /**
     * Get things of the day from a date
     *
     * @param date
     *
     * @return Things
     */
    private function getDayThings ($date, $favorites) 
    {
        $date = date('Y-m-d', $date);
        return $this->getThingsBetweenDates($date, $date, 'Day', $favorites);
    }

    /**
     * Get things of the week from a date
     * A week starts on Monday
     *
     * @param date
     * @param favorites Favorite things only
     *
     * @return Things
     */
    private function getWeekThings ($date, $favorites) 
    {
        $monday = date('w', $date) == 1 ? $date : strtotime('last monday', $date);
        $start  = date('Y-m-d', $monday);
        $end    = date('Y-m-d', strtotime('next sunday', $monday));

        return $this->getThingsBetweenDates($start, $end, 'Week', $favorites);
    }

    /**
     * Get things of the month from a date
     *
     * @param date
     * @param favorites Favorite things only
     *
     * @return Things
     */
    private function getMonthThings ($date, $favorites) 
    {
        $start  = date('Y-m-01', $date);
        $end    = date('Y-m-t', $date);

        return $this->getThingsBetweenDates($start, $end, 'Month', $favorites);
    }

    /**
     * Get things of the year from a date
     *
     * @param date
     * @param favorites Favorite things only
     *
     * @return Things
     */
    private function getYearThings ($date, $favorites) 
    {
        $start  = date('Y-01-01', $date);
        $end    = date('Y-12-31', $date);

        return $this->getThingsBetweenDates($start, $end, 'Year', $favorites);
    }

    /**
     * Get things between two dates
     *
     * @param start start date
     * @param end   end date
     * @param favorites Favorite things only
     *
     * @return Things
     */
    private function getThingsBetweenDates ($start, $end, $type, $favorites)
    {
        $qb = $this->entityManager->createQueryBuilder()
            ->add('select', 't')
            ->add('from', 'PositiveThinkingMainBundle:Thing t')
            ->add('where', 't.date between ?1 and ?2')
            ->setParameters(array(1 => $start, 2 => $end));

        if ($favorites == true)
        {
            $qb
                ->andWhere('t.favorite'.$type.' = ?3')
                ->setParameters(array(3 => 1));
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * Check is a date is valid
     *
     * @param date
     *
     * @return boolean
     */
    private function isValidDate($date)
    {
        if (preg_match("/^(\d{2})-(\d{2})-(\d{4})$/", $date, $matches) == 1) 
        {
            if (checkdate($matches[2], $matches[1], $matches[3])) 
            {
                return true;
            }
        }
        return false;
    }
}
