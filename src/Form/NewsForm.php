<?php

namespace App\Form;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class NewsForm
 * @package App\Form
 */
class NewsForm
{
    /**
     * @Assert\NotBlank
     * @var string
     */
    private $source;

    /**
     * @return string|null
     */
    public function getSource(): ?string
    {
        return $this->source;
    }

    /**
     * @param string $source
     * @return NewsForm
     */
    public function setSource(string $source): self
    {
        $this->source = $source;

        return $this;
    }
}
