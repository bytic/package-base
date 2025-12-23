<?php

declare(strict_types=1);

namespace ByTIC\PackageBase\ServiceProviders;

/**
 * Trait HasMigrationsTrait.
 */
trait HasTranslationsTrait
{
    /**
     * @return null|string
     */
    protected function translationsPath(): ?string
    {
        return null;
    }

    protected function bootTranslations()
    {
        if (false === $this->getContainer()->has('translator')) {
            return;
        }
        $folder = $this->translationsPath();
        if (empty($folder)) {
            return;
        }
        $this->loadTraslationsFrom($folder);
    }

    /**
     * @param string|array $path
     */
    protected function loadTraslationsFrom(array|string $basePath): void
    {
        $languages = $this->getContainer()->get('translation.languages');
        $translator = $this->getContainer()->get('translator');

        foreach ($languages as $language) {
            $path = $basePath . DIRECTORY_SEPARATOR . $language;
            if (is_dir($path)) {
                $translator->prependResource('php', $path, $language);
            }
        }
    }

}
