<?php
declare(strict_types=1);

namespace K3ssen\ExtendedGeneratorBundle\Generator;

use \K3ssen\GeneratorBundle\Generator\CrudGenerateOptions as BaseCrudGenerateOptions;

class CrudGenerateOptions extends BaseCrudGenerateOptions
{
    /** @var bool */
    protected $askUseDatatable;
    /** @var bool */
    protected $useDatatableDefault;
    /** @var bool */
    protected $useDatatable;

    public function getAskUseDatatable(): bool
    {
        return $this->askUseDatatable;
    }

    /**
     * @required
     */
    public function setAskUseDatatable(bool $askUseDatatable): self
    {
        $this->askUseDatatable = $askUseDatatable;
        return $this;
    }

    public function getUseDatatableDefault(): ?bool
    {
        return $this->useDatatableDefault;
    }

    /**
     * @required
     */
    public function setUseDatatableDefault(bool $useDatatableDefault): self
    {
        $this->useDatatableDefault = $useDatatableDefault;
        return $this;
    }

    public function getUseDatatable(): bool
    {
        return $this->useDatatable ?? $this->getUseDatatableDefault();
    }

    public function setUseDatatable(bool $useDatatable)
    {
        $this->useDatatable = $useDatatable;
        return $this;
    }
}
