<?php declare(strict_types=1);
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Event\Assertion;

use PHPUnit\Event\Event;
use PHPUnit\Event\Telemetry;
use PHPUnit\Framework\Constraint;
use SebastianBergmann\Exporter\Exporter;

/**
 * @no-named-arguments Parameter names are not covered by the backward compatibility promise for PHPUnit
 */
final class Made implements Event
{
    private Telemetry\Info $telemetryInfo;

    private mixed $value;

    private Constraint\Constraint $constraint;

    private string $message;

    private bool $hasFailed;

    public function __construct(Telemetry\Info $telemetryInfo, mixed $value, Constraint\Constraint $constraint, string $message, bool $hasFailed)
    {
        $this->telemetryInfo = $telemetryInfo;
        $this->value         = $value;
        $this->constraint    = $constraint;
        $this->message       = $message;
        $this->hasFailed     = $hasFailed;
    }

    public function telemetryInfo(): Telemetry\Info
    {
        return $this->telemetryInfo;
    }

    public function value(): mixed
    {
        return $this->value;
    }

    public function constraint(): Constraint\Constraint
    {
        return $this->constraint;
    }

    public function message(): string
    {
        return $this->message;
    }

    public function hasFailed(): bool
    {
        return $this->hasFailed;
    }

    public function asString(): string
    {
        return sprintf(
            '%s Assertion Made (Constraint: %s - Value: %s - Failed: %s - Message: %s)',
            $this->telemetryInfo()->asString(),
            $this->constraint()->toString(),
            $this->valueAsString(),
            $this->hasFailed() ? 'true' : 'false',
            $this->message()
        );
    }

    private function valueAsString(): string
    {
        return (new Exporter)->export($this->value());
    }
}
