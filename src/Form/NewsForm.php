<?php

namespace App\Form;

class NewsForm
{
    /** @var string */
    private $source;

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(string $source): self
    {
        $this->source = $source;

        return $this;
    }
}
