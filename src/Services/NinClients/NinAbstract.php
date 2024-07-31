<?php

namespace NextDeveloper\IAM\Services\NinClients;

/**
 * Abstract class NinAbstract
 *
 * This class provides a base structure for verifying citizens and foreign citizens.
 * It includes methods for checking required fields and converting strings to uppercase
 * with local-specific character mappings.
 */
abstract class NinAbstract
{
    /**
     * @var array $endpoints List of endpoints.
     */
    protected array $endpoints = [];

    /**
     * @var array $requiredFields List of required fields for citizens and foreign citizens.
     */
    protected array $requiredFields = [
        'citizen' => [],
        'foreign' => [],
    ];

    /**
     * @var array $data Data to be verified.
     */
    protected array $data;

    /**
     * @var string $locale Locale for character mapping.
     */
    protected string $locale = 'tr';

    /**
     * Constructor for NinAbstract.
     *
     * @param array $data Data to be verified.
     * @param string $locale Locale for character mapping.
     */
    public function __construct(array $data, string $locale = 'tr')
    {
        $this->data = $data;
        $this->locale = $locale;
        $this->checkRequiredFields($data);
    }

    /**
     * Abstract method to verify a citizen.
     *
     * @return bool True if verification is successful, false otherwise.
     */
    abstract protected function verifyCitizen(): bool;

    /**
     * Abstract method to verify a foreign citizen.
     *
     * @return bool True if verification is successful, false otherwise.
     */
    abstract protected function verifyForeignCitizen(): bool;

    /**
     * Verifies the data based on whether the subject is a citizen or a foreign citizen.
     *
     * @param bool $isCitizen True if the subject is a citizen, false if foreign.
     * @return bool True if verification is successful, false otherwise.
     */
    public function verify(bool $isCitizen = true): bool
    {
        try {
            $this->checkRequiredFields($this->data, $isCitizen);
            return $isCitizen ? $this->verifyCitizen() : $this->verifyForeignCitizen();
        } catch (\InvalidArgumentException $e) {
            return false;
        }
    }

    /**
     * Checks if the required fields are present in the data.
     *
     * @param array $fields Data fields to check.
     * @param bool $isCitizen True if the subject is a citizen, false if foreign.
     * @return bool True if all required fields are present, false otherwise.
     * @throws \InvalidArgumentException If a required field is missing.
     */
    protected function checkRequiredFields(array $fields, bool $isCitizen = true): bool
    {
        $requiredFields = $this->requiredFields[$isCitizen ? 'citizen' : 'foreign'];

        foreach ($requiredFields as $field) {
            if (!array_key_exists($field, $fields)) {
                throw new \InvalidArgumentException("Missing required field: $field");
            }
        }

        return true;
    }

    /**
     * Converts a string to uppercase with locale-specific character mappings.
     *
     * @param string $string The string to convert.
     * @return string The uppercase string.
     */
    protected function upperCase(string $string): string
    {
        // Character mapping
        $charMap = [
            'ç' => 'Ç', 'ğ' => 'Ğ', 'ö' => 'Ö', 'ş' => 'Ş', 'ü' => 'Ü',
            'ä' => 'Ä', 'ö' => 'Ö', 'ü' => 'Ü', 'ß' => 'SS',
            'à' => 'À', 'â' => 'Â', 'ç' => 'Ç', 'é' => 'É', 'è' => 'È',
            'ê' => 'Ê', 'ë' => 'Ë', 'î' => 'Î', 'ï' => 'Ï', 'ô' => 'Ô',
            'ù' => 'Ù', 'û' => 'Û', 'ü' => 'Ü', 'á' => 'Á', 'é' => 'É',
            'í' => 'Í', 'ñ' => 'Ñ', 'ó' => 'Ó', 'ú' => 'Ú'
        ];

        // Add Turkish-specific characters if locale is 'tr'
        if ($this->locale === 'tr') {
            $charMap['ı'] = 'I';
            $charMap['i'] = 'İ';
        }

        // Replace characters using array_map
        $upperString = strtr($string, $charMap);

        return mb_strtoupper($upperString, 'UTF-8');
    }
}
