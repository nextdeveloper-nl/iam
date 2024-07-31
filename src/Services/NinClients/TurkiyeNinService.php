<?php

namespace NextDeveloper\IAM\Services\NinClients;



/**
 * Class TurkiyeNinService
 *
 * This service class is responsible for verifying Turkish and foreign national identification numbers (NIN).
 * It extends the NinAbstract class and provides methods to verify both citizen and foreign NINs using SOAP clients.
 */
class TurkiyeNinService extends NinAbstract
{
    /**
     * @var array $endpoints
     *
     * An array containing the endpoints for citizen and foreign NIN verification.
     */
    protected array $endpoints = [
        'citizen',
        'foreign',
    ];

    /**
     * @var array $requiredFields
     *
     * An array defining the required fields for citizen and foreign NIN verification.
     */
    protected array $requiredFields = [
        'citizen' => ['nin', 'name', 'surname', 'year'],
        'foreign' => ['nin', 'name', 'surname', 'day', 'month', 'year'],
    ];

    /**
     * Constructor for TurkiyeNinService.
     *
     * @param array $data The data required for NIN verification.
     * @param string $locale The locale for the service, default is 'tr'.
     *
     * @throws \Exception If the endpoints are not configured.
     */
    public function __construct(array $data, string $locale = 'tr')
    {
        $this->endpoints['citizen'] = config('iam.nin.tr.endpoints.citizen');
        $this->endpoints['foreign'] = config('iam.nin.tr.endpoints.foreign');

        if (empty($this->endpoints['citizen']) || empty($this->endpoints['foreign'])) {
            throw new \Exception('Turkiye endpoints are not configured.');
        }

        parent::__construct($data, $locale);
    }

    /**
     * Verifies the citizen NIN using a SOAP client.
     *
     * @return bool True if the NIN is verified, false otherwise.
     *
     * @throws \SoapFault If there is an error with the SOAP request.
     */
    protected function verifyCitizen(): bool
    {
        $client = new \SoapClient($this->endpoints['citizen'], ['soap_version' => SOAP_1_2]);

        $response = $client->TCKimlikNoDogrula([
            'TCKimlikNo' => $this->data['nin'],
            'Ad'         => $this->upperCase($this->data['name']),
            'Soyad'      => $this->upperCase($this->data['surname']),
            'DogumYili'  => $this->data['year'],
        ]);

        return (bool) $response->TCKimlikNoDogrulaResult;
    }

    /**
     * Verifies the foreign citizen NIN using a SOAP client.
     *
     * @return bool True if the NIN is verified, false otherwise.
     *
     * @throws \SoapFault If there is an error with the SOAP request.
     */
    protected function verifyForeignCitizen(): bool
    {
        $client = new \SoapClient($this->endpoints['foreign'], ['soap_version' => SOAP_1_2]);

        $response = $client->YabanciKimlikNoDogrula([
            'KimlikNo' => $this->data['nin'],
            'Ad'       => $this->upperCase($this->data['name']),
            'Soyad'    => $this->upperCase($this->data['surname']),
            'DogumGun' => $this->data['day'],
            'DogumAy'  => $this->data['month'],
            'DogumYil' => $this->data['year'],
        ]);

        return (bool) $response->YabanciKimlikNoDogrulaResult;
    }
}
