<?php

namespace App\Twig;

use App\Entity\Timesheet;
use App\Util\Duration;
use App\Util\LocaleSettings;
use Symfony\Component\Intl\Locales;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigExtensions extends AbstractExtension
{
    /**
     * @var LocaleSettings
     */
    protected $localeSettings;
    /**
     * @var string
     */
    protected $locale;
    /**
     * @var Duration
     */
    protected $durationFormatter;

    /**
     * TwigExtensions constructor.
     */
    public function __construct(LocaleSettings $localeSettings)
    {
        $this->localeSettings = $localeSettings;
        $this->durationFormatter = new Duration();
    }


    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new TwigFilter('language', [$this, 'getLanguageName']),
            new TwigFilter('duration', [$this, 'duration']),
        ];
    }

    /**
     * @param string $language
     * @param string $inLocale
     * @return string
     */
    public function getLanguageName(string $language)
    {
        return ucfirst(Locales::getName($language, $language));
    }
    /**
     * Transforms seconds into a duration string.
     *
     * @param int|Timesheet $duration
     * @param string $format
     * @return string
     */
    public function duration($duration, $format = null)
    {
        $duration = $this->getSecondsForDuration($duration);

        if (null === $format) {
            $format = $this->localeSettings->getDurationFormat();
        }

        return $this->formatDuration($duration, $format);
    }
    private function getSecondsForDuration($duration): int
    {
        if (null === $duration) {
            $duration = 0;
        }

        if ($duration instanceof Timesheet) {
            if (null === $duration->getEnd()) {
                $duration = time() - $duration->getBegin()->getTimestamp();
            } else {
                $duration = $duration->getDuration();
            }
        }

        return (int) $duration;
    }

    protected function formatDuration(int $seconds, string $format): string
    {
        if ($seconds < 0) {
            return '?';
        }

        return $this->durationFormatter->format($seconds, $format);
    }

}
